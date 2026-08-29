<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\ActivityLog;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel as ExcelWriter;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $this->employeeQuery($request);

        $allowedPerPage = [10, 25, 50, 100];

        $perPage = $request->integer('per_page', 10);

        if (! in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $user = Auth::user();

        $query = Employee::query()
            ->with([
                'department',
                'position',
            ]);


        if ($user->isManagement()) {

            $query->where(
                'department_id',
                $user->employee->department_id
            );
        }

        $employees = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        $departments = Department::orderBy('name')
            ->get();

        $positions = Position::orderBy('name')
            ->get();

        return view(
            'employees.index',
            compact(
                'employees',
                'departments',
                'positions'
            )
        );
    }

    public function export(Request $request, string $format)
    {
        $employees = $this->employeeQuery($request)
            ->orderBy('employee_code')
            ->get();
        $filename = 'laporan-karyawan-' . now()->format('Y-m-d');

        return match ($format) {
            'xlsx' => Excel::download(new EmployeeExport($employees), "{$filename}.xlsx"),
            'csv' => Excel::download(new EmployeeExport($employees), "{$filename}.csv", ExcelWriter::CSV),
            'pdf' => Pdf::loadView('employees.report-pdf', compact('employees'))
                ->setPaper('a4', 'landscape')
                ->download("{$filename}.pdf"),
        };
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        DB::transaction(function () use ($request) {

            $data = $request->validated();

            $data['employee_code'] = $this->nextEmployeeCode();

            $employee = Employee::create($data);

            $this->logActivity(
                'CREATE',
                $employee,
                null,
                $employee->getAttributes()
            );

            return $employee;
        });

        return redirect()
            ->route('employees.index')
            ->with(
                'success',
                'Karyawan berhasil ditambahkan!'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee->load([
            'department',
            'position',
        ]);

        $activityLogs = ActivityLog::with('user')
            ->where('subject_type', Employee::class)
            ->where('subject_id', $employee->id)
            ->latest()
            ->get();

        $departmentIds = $activityLogs
            ->flatMap(function ($log) {
                return [
                    $log->old_values['department_id'] ?? null,
                    $log->new_values['department_id'] ?? null,
                ];
            })
            ->filter()
            ->unique();

        $positionIds = $activityLogs
            ->flatMap(function ($log) {
                return [
                    $log->old_values['position_id'] ?? null,
                    $log->new_values['position_id'] ?? null,
                ];
            })
            ->filter()
            ->unique();

        $departmentNames = Department::withTrashed()
            ->whereIn('id', $departmentIds)
            ->pluck('name', 'id');

        $positionNames = Position::withTrashed()
            ->whereIn('id', $positionIds)
            ->pluck('name', 'id');

        return view('employees.show', compact(
            'employee',
            'activityLogs',
            'departmentNames',
            'positionNames'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateEmployeeRequest $request,
        Employee $employee
    ) {
        DB::transaction(function () use ($request, $employee) {

            $oldValues = $employee->getAttributes();

            $employee->update(
                $request->validated()
            );

            $employee->refresh();

            $this->logActivity(
                'UPDATE',
                $employee,
                $oldValues,
                $employee->getAttributes()
            );
        });

        return redirect()
            ->route('employees.index')
            ->with('success', 'Karyawan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        DB::transaction(function () use ($employee) {
            $oldValues = $employee->getAttributes();
            $employee->delete();

            $this->logActivity('DELETE', $employee, $oldValues, null);
        });

        return redirect()->route('employees.index')
            ->with('success', 'Karyawan berhasil dihapus!');
    }

    private function nextEmployeeCode(): string
    {
        $highestCode = Employee::withTrashed()
            ->lockForUpdate()
            ->orderByRaw('CAST(employee_code AS UNSIGNED) DESC')
            ->value('employee_code');

        $nextNumber = ((int) $highestCode) + 1;

        return str_pad(
            (string) $nextNumber,
            3,
            '0',
            STR_PAD_LEFT
        );
    }

    private function employeeQuery(Request $request)
    {
        $query = Employee::with(['department', 'position']);

        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($query) use ($search) {
                $query->where('employee_code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('department', fn($query) => $query->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('position', fn($query) => $query->where('name', 'like', "%{$search}%"));
            });
        }

        foreach (['department_id', 'position_id', 'status'] as $filter) {
            if ($request->filled($filter)) {
                $query->where($filter, $request->input($filter));
            }
        }

        return $query;
    }

    private function logActivity(string $action, Employee $employee, ?array $oldValues, ?array $newValues): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'subject_type' => Employee::class,
            'subject_id' => $employee->id,
            'action' => $action,
            'old_values' => $oldValues,
            'new_values' => $newValues,
        ]);
    }
}
