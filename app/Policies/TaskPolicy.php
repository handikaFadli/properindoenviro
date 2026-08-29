<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /*
    |--------------------------------------------------------------------------
    | Before
    |--------------------------------------------------------------------------
    |
    | Admin otomatis boleh melakukan semua action terhadap Task.
    |
    */

    public function before(
        User $user,
        string $ability
    ): bool|null {

        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }


    /*
    |--------------------------------------------------------------------------
    | View Any
    |--------------------------------------------------------------------------
    */

    public function viewAny(User $user): bool
    {
        return in_array(
            $user->roleName(),
            [
                'manager',
                'supervisor',
                'staff',
            ],
            true
        );
    }


    /*
    |--------------------------------------------------------------------------
    | View
    |--------------------------------------------------------------------------
    */

    public function view(
        User $user,
        Task $task
    ): bool {

        $employee = $user->employee;

        if (!$employee) {
            return false;
        }


        /*
        | manager / supervisor
        | Task harus milik employee dalam department mereka.
        */

        if ($user->isManagement()) {

            return (int) $task->pic?->department_id
                === (int) $employee->department_id;
        }


        /*
        | staff
        | Task harus di-assign kepada dirinya.
        */

        if ($user->isstaff()) {

            return (int) $task->pic_id
                === (int) $employee->id;
        }


        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create(User $user): bool
    {
        return $user->isManagement();
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        User $user,
        Task $task
    ): bool {

        if (!$user->isManagement()) {
            return false;
        }

        return $this->sameDepartment(
            $user,
            $task
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Assign PIC
    |--------------------------------------------------------------------------
    */

    public function assignPic(
        User $user,
        Task $task
    ): bool {

        if (!$user->isManagement()) {
            return false;
        }

        return $this->sameDepartment(
            $user,
            $task
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Status
    |--------------------------------------------------------------------------
    |
    | manager / supervisor:
    | boleh update task department.
    |
    | staff:
    | hanya task miliknya.
    |
    */

    public function updateStatus(
        User $user,
        Task $task
    ): bool {

        $employee = $user->employee;

        if (!$employee) {
            return false;
        }


        if ($user->isManagement()) {

            return $this->sameDepartment(
                $user,
                $task
            );
        }


        if ($user->isstaff()) {

            return (int) $task->pic_id
                === (int) $employee->id;
        }


        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function delete(
        User $user,
        Task $task
    ): bool {

        if (!$user->isManagement()) {
            return false;
        }

        return $this->sameDepartment(
            $user,
            $task
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Helper Same Department
    |--------------------------------------------------------------------------
    */

    private function sameDepartment(
        User $user,
        Task $task
    ): bool {

        $employee = $user->employee;

        if (!$employee) {
            return false;
        }

        return (int) $task->pic?->department_id
            === (int) $employee->department_id;
    }
}
