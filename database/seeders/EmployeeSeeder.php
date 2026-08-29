<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            [
                'employee_code' => '777',
                'name' => 'Handika',
                'department' => 'IT',
                'position' => 'Programmer Junior',
                'email' => 'handika@properindoenviro.co.id',
                'status' => 'active',
            ],
            [
                'employee_code' => '001',
                'name' => 'Andi Saputra',
                'department' => 'Finance',
                'position' => 'Staff Finance',
                'email' => 'andi@properindoenviro.co.id',
                'status' => 'active',
            ],
            [
                'employee_code' => '002',
                'name' => 'Budi Santoso',
                'department' => 'IT',
                'position' => 'Programmer Junior',
                'email' => 'budi@properindoenviro.co.id',
                'status' => 'active',
            ],
            [
                'employee_code' => '003',
                'name' => 'Citra Lestari',
                'department' => 'HR',
                'position' => 'HR Administrator',
                'email' => 'citra@properindoenviro.co.id',
                'status' => 'active',
            ],
            [
                'employee_code' => '004',
                'name' => 'Dewi Anggraini',
                'department' => 'Environment',
                'position' => 'Environmental Staff',
                'email' => 'dewi@properindoenviro.co.id',
                'status' => 'active',
            ],
            [
                'employee_code' => '005',
                'name' => 'Eko Pratama',
                'department' => 'Operation',
                'position' => 'Operational Staff',
                'email' => 'eko@properindoenviro.co.id',
                'status' => 'active',
            ],
            [
                'employee_code' => '006',
                'name' => 'Hendra Wijaya',
                'department' => 'IT',
                'position' => 'Database Administrator',
                'email' => 'hendra@properindoenviro.co.id',
                'status' => 'active',
            ],
            [
                'employee_code' => '007',
                'name' => 'Lukman Hakim',
                'department' => 'IT',
                'position' => 'System Analyst',
                'email' => 'lukman@properindoenviro.co.id',
                'status' => 'active',
            ],
            [
                'employee_code' => '008',
                'name' => 'Maya Putri',
                'department' => 'HR',
                'position' => 'HR Supervisor',
                'email' => 'maya@properindoenviro.co.id',
                'status' => 'active',
            ],
            [
                'employee_code' => '009',
                'name' => 'Taufik Hidayat',
                'department' => 'Environment',
                'position' => 'Environmental Analyst',
                'email' => 'taufik@properindoenviro.co.id',
                'status' => 'active',
            ],
            [
                'employee_code' => '010',
                'name' => 'Rizky Maulana',
                'department' => 'IT',
                'position' => 'Web Developer',
                'email' => 'rizky@properindoenviro.co.id',
                'status' => 'active',
            ],
        ];

        foreach ($employees as $data) {

            $department = Department::where(
                'name',
                $data['department']
            )->firstOrFail();

            $position = Position::where('name', $data['position'])
                ->where('department_id', $department->id)
                ->firstOrFail();

            Employee::updateOrCreate(
                [
                    'employee_code' => $data['employee_code'],
                ],
                [
                    'name' => $data['name'],
                    'department_id' => $department->id,
                    'position_id' => $position->id,
                    'email' => $data['email'],
                    'status' => $data['status'],
                ]
            );
        }
    }
}
