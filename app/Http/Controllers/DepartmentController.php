<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use Illuminate\Http\Request;


class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Department::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Filter Status
        // if ($request->filled('status')) {
        //     $query->where('status', $request->status);
        // }

        // Sorting
        $query->latest();

        $departments = $query
            ->paginate($request->per_page ?? 10)
            ->withQueryString();

        return view('departments.index', compact('departments'));
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
    public function store(StoreDepartmentRequest $request)
    {
        $validated = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Cari termasuk data yang sudah dihapus
        |--------------------------------------------------------------------------
        */
        $department = Department::withTrashed()
            ->where('name', $request->name)
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Jika sudah ada
        |--------------------------------------------------------------------------
        */
        if ($department) {

            // Kalau soft deleted → restore
            if ($department->trashed()) {

                $department->restore();

                return redirect()
                    ->route('departments.index')
                    ->with('success', 'Departemen berhasil ditambahkan kembali.');
            }

            // Kalau masih aktif → duplicate
            return back()
                ->withInput()
                ->withErrors([
                    'name' => 'Nama departemen sudah digunakan.',
                ]);
        }

        Department::create([
            'name' => $validated['name'],
        ]);

        return redirect()->route('departments.index')
            ->with('success', 'Departemen berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $validated = $request->validated();

        $department->update([
            'name' => $validated['name'],
        ]);


        return redirect()->route('departments.index')
            ->with('success', 'Departemen berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Departemen berhasil dihapus!');
    }
}
