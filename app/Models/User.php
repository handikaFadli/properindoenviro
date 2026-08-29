<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected $fillable = [
        'employee_id',
        'name',
        'email',
        'password',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password'      => 'hashed',
            'last_login_at' => 'datetime',
            'deleted_at'    => 'datetime',
        ];
    }


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Role Helper
    |--------------------------------------------------------------------------
    */

    public function roleName(): ?string
    {
        return $this->employee
            ?->position
            ?->role
            ?->name;
    }


    public function isAdmin(): bool
    {
        return $this->roleName() === 'admin';
    }


    public function isManager(): bool
    {
        return $this->roleName() === 'manager';
    }


    public function isSupervisor(): bool
    {
        return $this->roleName() === 'supervisor';
    }


    public function isStaff(): bool
    {
        return $this->roleName() === 'staff';
    }


    /*
    |--------------------------------------------------------------------------
    | Manager + Supervisor
    |--------------------------------------------------------------------------
    */

    public function isManagement(): bool
    {
        return in_array(
            $this->roleName(),
            [
                'manager',
                'supervisor',
            ],
            true
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Admin + Manager + Supervisor
    |--------------------------------------------------------------------------
    */

    public function canManageTasks(): bool
    {
        return in_array(
            $this->roleName(),
            [
                'admin',
                'manager',
                'supervisor',
            ],
            true
        );
    }
}
