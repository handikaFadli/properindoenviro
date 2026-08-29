<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    /** @use HasFactory<\Database\Factories\TaskStatusFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'color',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function histories()
    {
        return $this->hasMany(TaskStatusHistory::class);
    }
}
