<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeeExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    public function __construct(private readonly Collection $employees) {}

    public function collection(): Collection
    {
        return $this->employees;
    }

    public function headings(): array
    {
        return ['Kode Karyawan', 'Nama', 'Email', 'Departemen', 'Posisi', 'Status'];
    }

    public function map($employee): array
    {
        return [
            $employee->employee_code,
            $employee->name,
            $employee->email,
            $employee->department?->name,
            $employee->position?->name,
            $employee->status === 'active' ? 'Aktif' : 'Non Aktif',
        ];
    }
}
