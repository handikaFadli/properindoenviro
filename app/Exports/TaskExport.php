<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TaskExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    public function __construct(private readonly Collection $tasks) {}

    public function collection(): Collection
    {
        return $this->tasks;
    }

    public function headings(): array
    {
        return ['Kode Tugas', 'Judul', 'PIC', 'Departemen', 'Deadline', 'Status', 'Prioritas'];
    }

    public function map($task): array
    {
        return [$task->task_code, $task->title, $task->pic?->name, $task->pic?->department?->name, $task->deadline?->format('d-m-Y'), $task->status?->name, $task->priority?->name];
    }
}
