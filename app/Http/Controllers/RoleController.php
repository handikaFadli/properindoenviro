<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Role::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Sorting
        $query->latest();

        $roles = $query
            ->paginate($request->per_page ?? 10)
            ->withQueryString();

        return view('roles.index', compact('roles'));
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
    public function store(StoreRoleRequest $request)
    {
        $validated = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Cari data yang sudah ada
        |--------------------------------------------------------------------------
        */
        $role = Role::where('name', $request->name)->first();

        /*
        |--------------------------------------------------------------------------
        | Jika sudah ada
        |--------------------------------------------------------------------------
        */
        if ($role) {

            return back()
                ->withInput()
                ->withErrors([
                    'name' => 'Nama role sudah digunakan.',
                ]);
        }

        Role::create([
            'name' => $validated['name'],
        ]);

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $validated = $request->validated();

        $role->update([
            'name' => $validated['name'],
        ]);


        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if ($role->positions()->exists()) {
            return redirect()->route('roles.index')
                ->with('error', 'Role tidak dapat dihapus karena masih digunakan pada posisi.');
        }

        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil dihapus!');
    }
}
