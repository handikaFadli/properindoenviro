<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize(
            'viewAny',
            User::class
        );

        $query = User::query()
            ->with([
                'employee.position.role',
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
                            'name',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'email',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhereHas(
                            'employee',
                            function ($employeeQuery) use ($search) {

                                $employeeQuery
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
        | Role Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('role_id')) {

            $query->whereHas(
                'employee.position',
                function ($positionQuery) use ($request) {

                    $positionQuery->where(
                        'role_id',
                        $request->input('role_id')
                    );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Per Page
        |--------------------------------------------------------------------------
        */

        $perPage = $request->integer(
            'per_page',
            10
        );

        if (
            !in_array(
                $perPage,
                [10, 25, 50, 100],
                true
            )
        ) {
            $perPage = 10;
        }


        /*
        |--------------------------------------------------------------------------
        | Data
        |--------------------------------------------------------------------------
        */

        $users = $query
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();


        $roles = Role::query()
            ->orderBy('name')
            ->get();


        return view(
            'users.index',
            compact(
                'users',
                'roles'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize(
            'create',
            User::class
        );

        $employees = Employee::query()
            ->where(
                'status',
                'active'
            )
            ->whereDoesntHave('user')
            ->with([
                'department',
                'position.role',
            ])
            ->orderBy('name')
            ->get();

        return view(
            'users.create',
            compact('employees')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize(
            'create',
            User::class
        );

        $employee = Employee::query()
            ->where(
                'id',
                $request->employee_id
            )
            ->where(
                'status',
                'active'
            )
            ->firstOrFail();


        /*
    |--------------------------------------------------------------------------
    | Cek apakah employee pernah memiliki akun
    |--------------------------------------------------------------------------
    */

        $existingUser = User::withTrashed()
            ->where(
                'employee_id',
                $employee->id
            )
            ->first();


        /*
    |--------------------------------------------------------------------------
    | Jika user sudah ada
    |--------------------------------------------------------------------------
    */

        if ($existingUser) {

            /*
        |--------------------------------------------------------------------------
        | Jika masih aktif
        |--------------------------------------------------------------------------
        */

            if (!$existingUser->trashed()) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'employee_id' =>
                        'Karyawan tersebut sudah memiliki akun.',
                    ]);
            }


            /*
        |--------------------------------------------------------------------------
        | Jika sebelumnya dinonaktifkan
        |--------------------------------------------------------------------------
        |
        | Restore akun lama, lalu perbarui data login.
        |
        */

            $existingUser->restore();

            $existingUser->update([
                'name' =>
                $employee->name,

                'email' =>
                $request->email,

                'password' =>
                $request->password,

                'last_login_at' =>
                null,
            ]);


            return redirect()
                ->route('users.index')
                ->with(
                    'success',
                    "Akun {$existingUser->name} berhasil diaktifkan kembali."
                );
        }


        /*
    |--------------------------------------------------------------------------
    | Buat akun baru
    |--------------------------------------------------------------------------
    */

        $user = User::create([
            'employee_id' =>
            $employee->id,

            'name' =>
            $employee->name,

            'email' =>
            $request->email,

            'password' =>
            $request->password,
        ]);


        return redirect()
            ->route('users.index')
            ->with(
                'success',
                "Akun {$user->name} berhasil dibuat."
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize(
            'create',
            User::class
        );

        $employees = Employee::query()
            ->where(
                'status',
                'active'
            )
            ->whereDoesntHave('user')
            ->with([
                'department',
                'position.role',
            ])
            ->orderBy('name')
            ->get();

        return view(
            'users.edit',
            compact('employees', 'user')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize(
            'update',
            $user
        );

        $user->update([
            'email' =>
            $request->email,
        ]);

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Data user berhasil diperbarui.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize(
            'delete',
            $user
        );

        if (
            Auth::id()
            === $user->id
        ) {
            return back()->withErrors([
                'user' =>
                'Anda tidak dapat menonaktifkan akun yang sedang digunakan.',
            ]);
        }

        $name = $user->name;

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                "User {$name} berhasil dinonaktifkan."
            );
    }

    public function resetPassword(
        Request $request,
        User $user
    ) {
        $this->authorize(
            'update',
            $user
        );

        $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $user->update([
            'password' =>
            $request->password,
        ]);

        return back()->with(
            'success',
            "Password {$user->name} berhasil direset."
        );
    }
}
