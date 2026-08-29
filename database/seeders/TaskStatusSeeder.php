<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'code' => 'not_started',
                'name' => 'Belum Dimulai',
                'color' => 'gray',
                'sort_order' => 1,
            ],
            [
                'code' => 'in_progress',
                'name' => 'Sedang Dikerjakan',
                'color' => 'blue',
                'sort_order' => 2,
            ],
            [
                'code' => 'completed',
                'name' => 'Selesai',
                'color' => 'green',
                'sort_order' => 3,
            ],
        ];

        foreach ($statuses as $status) {
            TaskStatus::updateOrCreate(
                ['code' => $status['code']],
                $status
            );
        }
    }
}
