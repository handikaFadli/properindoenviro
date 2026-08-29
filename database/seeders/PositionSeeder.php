<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Position;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            [
                'name' => 'Staff Finance',
                'department' => 'Finance',
                'role' => 'staff',
            ],
            [
                'name' => 'Programmer Junior',
                'department' => 'IT',
                'role' => 'staff',
            ],
            [
                'name' => 'HR Administrator',
                'department' => 'HR',
                'role' => 'admin',
            ],
            [
                'name' => 'Environmental Staff',
                'department' => 'Environment',
                'role' => 'staff',
            ],
            [
                'name' => 'Operational Staff',
                'department' => 'Operation',
                'role' => 'staff',
            ],
            [
                'name' => 'Database Administrator',
                'department' => 'IT',
                'role' => 'staff',
            ],
            [
                'name' => 'System Analyst',
                'department' => 'IT',
                'role' => 'manager',
            ],
            [
                'name' => 'HR Supervisor',
                'department' => 'HR',
                'role' => 'manager',
            ],
            [
                'name' => 'Environmental Analyst',
                'department' => 'Environment',
                'role' => 'staff',
            ],
            [
                'name' => 'Web Developer',
                'department' => 'IT',
                'role' => 'staff',
            ],
        ];

        foreach ($positions as $position) {

            $department = Department::where(
                'name',
                $position['department']
            )->firstOrFail();

            $role = Role::where(
                'name',
                $position['role']
            )->firstOrFail();

            Position::updateOrCreate(
                [
                    'name' => $position['name'],
                    'department_id' => $department->id,
                ],
                [
                    'role_id' => $role->id,
                ]
            );
        }
    }
}
