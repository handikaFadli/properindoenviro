<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(
        User $user,
        User $targetUser
    ): bool {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(
        User $user,
        User $targetUser
    ): bool {
        return $user->isAdmin();
    }

    public function delete(
        User $user,
        User $targetUser
    ): bool {

        /*
        |--------------------------------------------------------------------------
        | Admin tidak boleh menghapus dirinya sendiri
        |--------------------------------------------------------------------------
        */

        if ($user->id === $targetUser->id) {
            return false;
        }

        return $user->isAdmin();
    }
}
