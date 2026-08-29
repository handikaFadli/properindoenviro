<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    /** @use HasFactory<\Database\Factories\DepartmentFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name"
    ];

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
