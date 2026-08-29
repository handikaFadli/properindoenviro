<?php

namespace Database\Seeders;

use App\Models\TaskPriority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = [
            [
                'code' => 'low',
                'name' => 'Rendah',
                'color' => 'gray',
                'sort_order' => 1,
            ],
            [
                'code' => 'medium',
                'name' => 'Sedang',
                'color' => 'yellow',
                'sort_order' => 2,
            ],
            [
                'code' => 'high',
                'name' => 'Tinggi',
                'color' => 'red',
                'sort_order' => 3,
            ],
        ];

        foreach ($priorities as $priority) {
            TaskPriority::updateOrCreate(
                ['code' => $priority['code']],
                $priority
            );
        }
    }
}
