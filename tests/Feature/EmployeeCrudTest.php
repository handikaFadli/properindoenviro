<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_crud_generates_codes_and_records_activity_history(): void
    {
        $user = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.test',
            'password' => 'password',
        ]);
        $department = Department::create(['name' => 'Technology']);
        $role = Role::create(['name' => 'staff']);
        $position = Position::create([
            'name' => 'Developer',
            'department_id' => $department->id,
            'role_id' => $role->id,
        ]);

        $payload = [
            'name' => 'Jane Doe',
            'department_id' => $department->id,
            'position_id' => $position->id,
            'email' => 'jane@example.test',
            'status' => 'active',
        ];

        $this->actingAs($user)->post(route('employees.store'), $payload)
            ->assertRedirect(route('employees.index'));

        $employee = Employee::firstOrFail();
        $this->assertSame('001', $employee->employee_code);
        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $user->id,
            'subject_type' => Employee::class,
            'subject_id' => $employee->id,
            'action' => 'CREATE',
        ]);

        $filename = 'laporan-karyawan-'.now()->format('Y-m-d');

        $this->actingAs($user)->get(route('employees.export', ['format' => 'xlsx']))
            ->assertOk()
            ->assertDownload("{$filename}.xlsx");
        $this->actingAs($user)->get(route('employees.export', ['format' => 'csv']))
            ->assertOk()
            ->assertDownload("{$filename}.csv");
        $this->actingAs($user)->get(route('employees.export', ['format' => 'pdf']))
            ->assertOk()
            ->assertDownload("{$filename}.pdf");

        $this->actingAs($user)->put(route('employees.update', $employee), [...$payload, 'name' => 'Jane Smith'])
            ->assertRedirect(route('employees.index'));
        $this->assertDatabaseHas('activity_logs', ['subject_id' => $employee->id, 'action' => 'UPDATE']);

        $this->actingAs($user)->delete(route('employees.destroy', $employee))
            ->assertRedirect(route('employees.index'));
        $this->assertSoftDeleted('employees', ['id' => $employee->id]);
        $this->assertDatabaseHas('activity_logs', ['subject_id' => $employee->id, 'action' => 'DELETE']);
    }
}
