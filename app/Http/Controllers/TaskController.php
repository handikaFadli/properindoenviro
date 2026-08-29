<?php

namespace App\Http\Controllers;

use App\Exports\TaskExport;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Employee;
use App\Models\Task;
use App\Models\TaskPriority;
use App\Models\TaskStatus;
use App\Models\TaskStatusHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel as ExcelWriter;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Task::class);

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Base Query berdasarkan Role
        |--------------------------------------------------------------------------
        */

        $baseQuery = Task::query()
            ->visibleTo($user);

        /*
        |--------------------------------------------------------------------------
        | Query Table
        |--------------------------------------------------------------------------
        */

        $query = Task::query()
            ->visibleTo($user)
            ->with([
                'pic.department',
                'status',
                'priority',
                'creator',
            ]);

        /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

        if ($request->filled('search')) {

            $search = trim(
                $request->input('search')
            );

            $query->where(
                function ($query) use ($search) {

                    $query
                        ->where(
                            'task_code',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'title',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'description',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhereHas(
                            'pic',
                            function ($picQuery) use ($search) {

                                $picQuery
                                    ->where(
                                        'name',
                                        'like',
                                        "%{$search}%"
                                    )

                                    ->orWhere(
                                        'employee_code',
                                        'like',
                                        "%{$search}%"
                                    );
                            }
                        );
                }
            );
        }

        /*
    |--------------------------------------------------------------------------
    | PIC
    |--------------------------------------------------------------------------
    */

        if ($request->filled('pic_id')) {

            $query->where(
                'pic_id',
                $request->input('pic_id')
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

        if ($request->filled('task_status_id')) {

            $query->where(
                'task_status_id',
                $request->input(
                    'task_status_id'
                )
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Priority
    |--------------------------------------------------------------------------
    */

        if ($request->filled('task_priority_id')) {

            $query->where(
                'task_priority_id',
                $request->input(
                    'task_priority_id'
                )
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Deadline Start
    |--------------------------------------------------------------------------
    */

        if ($request->filled('deadline_start')) {

            $query->whereDate(
                'deadline',
                '>=',
                $request->input(
                    'deadline_start'
                )
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Deadline End
    |--------------------------------------------------------------------------
    */

        if ($request->filled('deadline_end')) {

            $query->whereDate(
                'deadline',
                '<=',
                $request->input(
                    'deadline_end'
                )
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Order
    |--------------------------------------------------------------------------
    */

        $query
            ->orderBy('deadline')
            ->orderByDesc('created_at');

        /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

        $perPage = $request->integer(
            'per_page',
            10
        );

        if (
            ! in_array(
                $perPage,
                [10, 25, 50, 100],
                true
            )
        ) {
            $perPage = 10;
        }

        $tasks = $query
            ->paginate($perPage)
            ->withQueryString();

        /*
    |--------------------------------------------------------------------------
    | Statistics berdasarkan Role
    |--------------------------------------------------------------------------
    */

        $stats = [

            'total' => (clone $baseQuery)
                ->count(),

            'not_started' => (clone $baseQuery)
                ->whereHas(
                    'status',
                    function ($query) {

                        $query->where(
                            'code',
                            'not_started'
                        );
                    }
                )
                ->count(),

            'in_progress' => (clone $baseQuery)
                ->whereHas(
                    'status',
                    function ($query) {

                        $query->where(
                            'code',
                            'in_progress'
                        );
                    }
                )
                ->count(),

            'completed' => (clone $baseQuery)
                ->whereHas(
                    'status',
                    function ($query) {

                        $query->where(
                            'code',
                            'completed'
                        );
                    }
                )
                ->count(),

            'overdue' => (clone $baseQuery)
                ->whereDate(
                    'deadline',
                    '<',
                    today()
                )
                ->whereHas(
                    'status',
                    function ($query) {

                        $query->where(
                            'code',
                            '!=',
                            'completed'
                        );
                    }
                )
                ->count(),
        ];

        /*
    |--------------------------------------------------------------------------
    | Employee Filter
    |--------------------------------------------------------------------------
    */

        $employeesQuery = Employee::query()
            ->where(
                'status',
                'active'
            );

        /*
    | Manager / Supervisor hanya melihat employee department sendiri.
    */

        if ($user->isManagement()) {

            $employeesQuery->where(
                'department_id',
                $user->employee->department_id
            );
        }

        /*
    | Staff hanya dirinya.
    */

        if ($user->isStaff()) {

            $employeesQuery->where(
                'id',
                $user->employee->id
            );
        }

        $employees = $employeesQuery
            ->orderBy('name')
            ->get();

        /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

        $statuses = TaskStatus::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        /*
    |--------------------------------------------------------------------------
    | Priority
    |--------------------------------------------------------------------------
    */

        $priorities = TaskPriority::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view(
            'tasks.index',
            compact(
                'tasks',
                'stats',
                'employees',
                'statuses',
                'priorities'
            )
        );
    }

    public function export(Request $request, string $format)
    {
        $this->authorize('viewAny', Task::class);

        $query = Task::query()->visibleTo(Auth::user())->with(['pic.department', 'status', 'priority']);

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(fn ($query) => $query->where('task_code', 'like', "%{$search}%")
                ->orWhere('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhereHas('pic', fn ($query) => $query->where('name', 'like', "%{$search}%")->orWhere('employee_code', 'like', "%{$search}%")));
        }

        foreach (['pic_id', 'task_status_id', 'task_priority_id'] as $filter) {
            if ($request->filled($filter)) {
                $query->where($filter, $request->input($filter));
            }
        }

        if ($request->filled('deadline_start')) {
            $query->whereDate('deadline', '>=', $request->input('deadline_start'));
        }

        if ($request->filled('deadline_end')) {
            $query->whereDate('deadline', '<=', $request->input('deadline_end'));
        }

        $tasks = $query->orderBy('deadline')->orderByDesc('created_at')->get();
        $filename = 'laporan-tugas-'.now()->format('Y-m-d');

        return match ($format) {
            'xlsx' => Excel::download(new TaskExport($tasks), "{$filename}.xlsx"),
            'csv' => Excel::download(new TaskExport($tasks), "{$filename}.csv", ExcelWriter::CSV),
            'pdf' => Pdf::loadView('tasks.report-pdf', compact('tasks'))->setPaper('a4', 'landscape')->download("{$filename}.pdf"),
        };
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize(
            'create',
            Task::class
        );

        $user = Auth::user();

        $employeesQuery = Employee::query()
            ->where('status', 'active');

        /*
    |--------------------------------------------------------------------------
    | Manager / Supervisor
    |--------------------------------------------------------------------------
    | Hanya dapat melihat PIC dari departemen sendiri.
    */
        if ($user->isManagement()) {
            $employeesQuery->where(
                'department_id',
                $user->employee->department_id
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    | Tidak diberi filter department,
    | sehingga dapat memilih semua employee.
    */

        $employees = $employeesQuery
            ->orderBy('name')
            ->get();

        $priorities = TaskPriority::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view(
            'tasks.create',
            compact(
                'employees',
                'priorities'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $this->authorize(
            'create',
            Task::class
        );

        $user = Auth::user();

        /*
    |--------------------------------------------------------------------------
    | Validasi PIC yang boleh dipilih
    |--------------------------------------------------------------------------
    */

        $picQuery = Employee::query()
            ->where(
                'id',
                $request->pic_id
            )
            ->where(
                'status',
                'active'
            );

        /*
    | Manager / Supervisor:
    | PIC wajib berasal dari department sendiri.
    */

        if ($user->isManagement()) {

            $picQuery->where(
                'department_id',
                $user->employee->department_id
            );
        }

        $pic = $picQuery->first();

        if (! $pic) {

            return back()
                ->withInput()
                ->withErrors([
                    'pic_id' => 'PIC tidak valid atau berada di luar departemen Anda.',
                ]);
        }

        /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

        $task = DB::transaction(
            function () use (
                $request,
                $pic
            ) {

                $defaultStatus = TaskStatus::query()
                    ->where(
                        'code',
                        'not_started'
                    )
                    ->where(
                        'is_active',
                        true
                    )
                    ->firstOrFail();

                $task = Task::create([

                    'task_code' => $this->nextTaskCode(),

                    'title' => $request->title,

                    'description' => $request->description,

                    'pic_id' => $pic->id,

                    'deadline' => $request->deadline,

                    'task_status_id' => $defaultStatus->id,

                    'task_priority_id' => $request->task_priority_id,

                    'created_by' => Auth::id(),

                    'completed_at' => null,
                ]);

                /*
            |--------------------------------------------------------------------------
            | Initial Status History
            |--------------------------------------------------------------------------
            */

                TaskStatusHistory::create([

                    'task_id' => $task->id,

                    'task_status_id' => $defaultStatus->id,

                    'note' => 'Tugas dibuat dengan status awal '
                        .$defaultStatus->name
                        .'.',

                    'changed_by' => Auth::id(),
                ]);

                return $task;
            }
        );

        return redirect()
            ->route(
                'tasks.show',
                $task
            )
            ->with(
                'success',
                "Tugas {$task->task_code} berhasil dibuat."
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load([
            'pic.department',
            'pic.position',
            'status',
            'priority',
            'creator.employee',
            'statusHistories.status',
            'statusHistories.changedBy.employee',
        ]);

        /*
    |--------------------------------------------------------------------------
    | Authorization
    |--------------------------------------------------------------------------
    */

        $this->authorize(
            'view',
            $task
        );

        $user = Auth::user();

        /*
    |--------------------------------------------------------------------------
    | PIC Dropdown
    |--------------------------------------------------------------------------
    */

        $employees = collect();

        if ($user->canManageTasks()) {

            $employeesQuery = Employee::query()
                ->where(
                    'status',
                    'active'
                );

            /*
        | Manager / Supervisor:
        | hanya employee department sendiri.
        */

            if ($user->isManagement()) {

                $employeesQuery->where(
                    'department_id',
                    $user->employee->department_id
                );
            }

            $employees = $employeesQuery
                ->orderBy('name')
                ->get();
        }

        /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

        $statuses = TaskStatus::query()
            ->where(
                'is_active',
                true
            )
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view(
            'tasks.show',
            compact(
                'task',
                'employees',
                'statuses',
                'user'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $task->load([
            'pic.department',
            'status',
            'priority',
            'creator.employee',
        ]);

        $this->authorize(
            'update',
            $task
        );

        $user = Auth::user();

        /*
    |--------------------------------------------------------------------------
    | PIC
    |--------------------------------------------------------------------------
    */

        $employeesQuery = Employee::query()
            ->where(
                'status',
                'active'
            );

        if ($user->isManagement()) {

            $employeesQuery->where(
                'department_id',
                $user->employee->department_id
            );
        }

        $employees = $employeesQuery
            ->orderBy('name')
            ->get();

        /*
    |--------------------------------------------------------------------------
    | Priority
    |--------------------------------------------------------------------------
    */

        $priorities = TaskPriority::query()
            ->where(
                'is_active',
                true
            )
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view(
            'tasks.edit',
            compact(
                'task',
                'employees',
                'priorities'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateTaskRequest $request,
        Task $task
    ) {
        $task->load('pic');

        $this->authorize(
            'update',
            $task
        );

        $user = Auth::user();

        /*
    |--------------------------------------------------------------------------
    | Validate PIC
    |--------------------------------------------------------------------------
    */

        $picQuery = Employee::query()
            ->where(
                'id',
                $request->pic_id
            )
            ->where(
                'status',
                'active'
            );

        if ($user->isManagement()) {

            $picQuery->where(
                'department_id',
                $user->employee->department_id
            );
        }

        $pic = $picQuery->first();

        if (! $pic) {

            return back()
                ->withInput()
                ->withErrors([
                    'pic_id' => 'PIC tidak valid atau berada di luar departemen Anda.',
                ]);
        }

        DB::transaction(
            function () use (
                $request,
                $task,
                $pic
            ) {

                $task->update([

                    'title' => $request->title,

                    'description' => $request->description,

                    'pic_id' => $pic->id,

                    'deadline' => $request->deadline,

                    'task_priority_id' => $request->task_priority_id,
                ]);
            }
        );

        return redirect()
            ->route(
                'tasks.show',
                $task
            )
            ->with(
                'success',
                "Tugas {$task->task_code} berhasil diperbarui."
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->load(
            'pic.department'
        );

        $this->authorize(
            'delete',
            $task
        );

        $taskCode =
            $task->task_code;

        DB::transaction(
            function () use ($task) {

                $task->delete();
            }
        );

        return redirect()
            ->route('tasks.index')
            ->with(
                'success',
                "Tugas {$taskCode} berhasil dihapus."
            );
    }

    private function nextTaskCode(): string
    {
        $highestCode = Task::withTrashed()
            ->lockForUpdate()
            ->pluck('task_code')
            ->map(function ($code) {

                if (
                    preg_match(
                        '/^TSK-(\d+)$/',
                        $code,
                        $matches
                    )
                ) {

                    return (int) $matches[1];
                }

                return null;
            })
            ->filter(fn ($number) => $number !== null)
            ->max() ?? 0;

        return 'TSK-'.str_pad(
            (string) ($highestCode + 1),
            3,
            '0',
            STR_PAD_LEFT
        );
    }

    public function assignPic(
        Request $request,
        Task $task
    ) {
        $task->load(
            'pic.department'
        );

        $this->authorize(
            'assignPic',
            $task
        );

        $request->validate(
            [
                'pic_id' => [
                    'required',
                    'integer',
                    'exists:employees,id',
                ],
            ],
            [
                'pic_id.required' => 'PIC wajib dipilih.',

                'pic_id.exists' => 'PIC tidak ditemukan.',
            ]
        );

        $user = Auth::user();

        /*
    |--------------------------------------------------------------------------
    | Target PIC
    |--------------------------------------------------------------------------
    */

        $employeeQuery = Employee::query()
            ->where(
                'id',
                $request->pic_id
            )
            ->where(
                'status',
                'active'
            );

        /*
    | Manager / Supervisor:
    | tidak boleh assign ke department lain.
    */

        if ($user->isManagement()) {

            $employeeQuery->where(
                'department_id',
                $user->employee->department_id
            );
        }

        $employee = $employeeQuery->first();

        if (! $employee) {

            return back()->withErrors([
                'pic_id' => 'PIC tidak valid atau berada di luar departemen Anda.',
            ]);
        }

        /*
    |--------------------------------------------------------------------------
    | PIC tidak berubah
    |--------------------------------------------------------------------------
    */

        if (
            (int) $task->pic_id
            ===
            (int) $employee->id
        ) {

            return back()->with(
                'info',
                'PIC tugas tidak berubah.'
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

        $task->update([
            'pic_id' => $employee->id,
        ]);

        return redirect()
            ->route(
                'tasks.show',
                $task
            )
            ->with(
                'success',
                "PIC berhasil dipindahkan ke {$employee->name}."
            );
    }

    public function updateStatus(
        Request $request,
        Task $task
    ) {
        $task->load(
            'pic.department'
        );

        $this->authorize(
            'updateStatus',
            $task
        );

        $request->validate(
            [
                'task_status_id' => [
                    'required',
                    'integer',
                    'exists:task_statuses,id',
                ],

                'note' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],
            ],
            [
                'task_status_id.required' => 'Status wajib dipilih.',

                'task_status_id.exists' => 'Status tidak ditemukan.',

                'note.max' => 'Catatan maksimal 1000 karakter.',
            ]
        );

        /*
    |--------------------------------------------------------------------------
    | Status Baru
    |--------------------------------------------------------------------------
    */

        $newStatus = TaskStatus::query()
            ->where(
                'id',
                $request->task_status_id
            )
            ->where(
                'is_active',
                true
            )
            ->first();

        if (! $newStatus) {

            return back()
                ->withErrors([
                    'task_status_id' => 'Status tidak aktif atau tidak tersedia.',
                ]);
        }

        /*
    |--------------------------------------------------------------------------
    | Sama
    |--------------------------------------------------------------------------
    */

        if (
            (int) $task->task_status_id
            ===
            (int) $newStatus->id
        ) {

            return back()->with(
                'info',
                'Status tugas tidak berubah.'
            );
        }

        DB::transaction(
            function () use (
                $request,
                $task,
                $newStatus
            ) {

                /*
            |--------------------------------------------------------------------------
            | Update Task
            |--------------------------------------------------------------------------
            */

                $task->update([

                    'task_status_id' => $newStatus->id,

                    'completed_at' => $newStatus->code === 'completed'
                        ? now()
                        : null,
                ]);

                /*
            |--------------------------------------------------------------------------
            | Status History
            |--------------------------------------------------------------------------
            */

                TaskStatusHistory::create([

                    'task_id' => $task->id,

                    'task_status_id' => $newStatus->id,

                    'note' => $request->filled('note')
                        ? trim($request->note)
                        : null,

                    'changed_by' => Auth::id(),
                ]);
            }
        );

        return redirect()
            ->route(
                'tasks.show',
                $task
            )
            ->with(
                'success',
                "Status berhasil diubah menjadi {$newStatus->name}."
            );
    }
}
