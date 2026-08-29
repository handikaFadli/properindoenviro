<?php

namespace App\Models;

use Database\Factories\EmployeeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    /** @use HasFactory<EmployeeFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_code',
        'name',
        'department_id',
        'position_id',
        'email',
        'status',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'pic_id');
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'subject');
    }
}
