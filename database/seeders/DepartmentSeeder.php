<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'Finance',
            'IT',
            'HR',
            'Environment',
            'Operation',
        ];

        foreach ($departments as $department) {
            Department::updateOrCreate([
                'name' => $department,
            ]);
        }
    }
}
