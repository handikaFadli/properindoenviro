<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatusHistory extends Model
{
    /** @use HasFactory<\Database\Factories\TaskStatusHistoryFactory> */
    use HasFactory;

    protected $fillable = [
        'task_id',
        'task_status_id',
        'note',
        'changed_by',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function status()
    {
        return $this->belongsTo(
            TaskStatus::class,
            'task_status_id'
        );
    }

    public function changedBy()
    {
        return $this->belongsTo(
            User::class,
            'changed_by'
        );
    }
}
