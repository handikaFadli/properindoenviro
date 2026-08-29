<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    /** @use HasFactory<\Database\Factories\PositionFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "department_id",
        "role_id",
        "name"
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
