<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use App\Models\Role;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use Illuminate\Http\Request;


class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Position::with(['department', 'role']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('department', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('role', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Sorting
        $query->latest();

        $positions = $query
            ->paginate($request->per_page ?? 10)
            ->withQueryString();

        $departments = Department::orderBy('name')->get();
        $roles = Role::orderBy('name')->get();

        return view('positions.index', compact('positions', 'departments', 'roles'));
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
    public function store(StorePositionRequest $request)
    {
        $validated = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Cari termasuk data yang sudah dihapus
        |--------------------------------------------------------------------------
        */
        $position = Position::withTrashed()
            ->where('name', $request->name)
            ->where('department_id', $request->department_id)
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Jika sudah ada
        |--------------------------------------------------------------------------
        */
        if ($position) {

            // Kalau soft deleted → restore
            if ($position->trashed()) {

                $position->restore();
                $position->update([
                    'role_id' => $validated['role_id'],
                ]);

                return redirect()
                    ->route('positions.index')
                    ->with('success', 'Posisi berhasil ditambahkan kembali.');
            }

            // Kalau masih aktif → duplicate
            return back()
                ->withInput()
                ->withErrors([
                    'name' => 'Nama posisi sudah digunakan pada departemen ini.',
                ]);
        }

        Position::create([
            'name' => $validated['name'],
            'department_id' => $validated['department_id'],
            'role_id' => $validated['role_id'],
        ]);

        return redirect()->route('positions.index')
            ->with('success', 'Posisi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePositionRequest $request, Position $position)
    {
        $validated = $request->validated();

        $position->update([
            'name' => $validated['name'],
            'department_id' => $validated['department_id'],
            'role_id' => $validated['role_id'],
        ]);


        return redirect()->route('positions.index')
            ->with('success', 'Posisi berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
        $position->delete();

        return redirect()->route('positions.index')
            ->with('success', 'Posisi berhasil dihapus!');
    }
}
