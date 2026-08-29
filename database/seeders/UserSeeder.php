<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{

		$employees = Employee::all();

		foreach ($employees as $employee) {

			User::updateOrCreate(
				[
					'employee_id' => $employee->id,
				],
				[
					'name' => $employee->name,
					'email' => $employee->email,
					'password' => Hash::make('password'),
				]
			);
		}
	}
}
