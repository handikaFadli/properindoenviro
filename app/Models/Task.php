<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "task_code",
        "title",
        "description",
        "pic_id",
        "deadline",
        "task_status_id",
        "task_priority_id",
        "created_by",
        "completed_at",
    ];

    protected $casts = [
        'deadline' => 'date',
        'completed_at' => 'datetime',
    ];

    public function pic()
    {
        return $this->belongsTo(
            Employee::class,
            'pic_id'
        );
    }

    public function status()
    {
        return $this->belongsTo(
            TaskStatus::class,
            'task_status_id'
        );
    }

    public function priority()
    {
        return $this->belongsTo(
            TaskPriority::class,
            'task_priority_id'
        );
    }

    public function creator()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function statusHistories()
    {
        return $this->hasMany(
            TaskStatusHistory::class
        );
    }
    /*
    |--------------------------------------------------------------------------
    | Scope Visible To User
    |--------------------------------------------------------------------------
    |
    | Admin
    | └── Semua task
    |
    | Manager / Supervisor
    | └── Semua task dalam departemennya
    |
    | Staff
    | └── Hanya task yang pic_id = employee dirinya
    |
    */

    public function scopeVisibleTo(
        Builder $query,
        User $user
    ): Builder {

        $employee = $user->employee;

        /*
        |--------------------------------------------------------------------------
        | User tidak memiliki employee
        |--------------------------------------------------------------------------
        */

        if (!$employee) {
            return $query->whereRaw('1 = 0');
        }


        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        if ($user->isAdmin()) {
            return $query;
        }


        /*
        |--------------------------------------------------------------------------
        | Manager / Supervisor
        |--------------------------------------------------------------------------
        */

        if ($user->isManagement()) {

            return $query->whereHas(
                'pic',
                function ($picQuery) use ($employee) {

                    $picQuery->where(
                        'department_id',
                        $employee->department_id
                    );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Staff
        |--------------------------------------------------------------------------
        */

        if ($user->isStaff()) {

            return $query->where(
                'pic_id',
                $employee->id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Unknown Role
        |--------------------------------------------------------------------------
        */

        return $query->whereRaw('1 = 0');
    }
}
