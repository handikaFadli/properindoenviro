<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	public function index()
	{
		$user = Auth::user();

		$employee = $user->employee;


		/*
        |--------------------------------------------------------------------------
        | Task Scope
        |--------------------------------------------------------------------------
        |
        | Admin              : semua task
        | Manager/Supervisor : task departemen sendiri
        | Staff              : task dirinya sendiri
        |
        */

		$taskBaseQuery = Task::query()
			->visibleTo($user);


		/*
        |--------------------------------------------------------------------------
        | Employee Scope
        |--------------------------------------------------------------------------
        */

		$employeeQuery = Employee::query()
			->with([
				'department',
				'position.role',
			]);


		/*
        |--------------------------------------------------------------------------
        | Manager / Supervisor
        |--------------------------------------------------------------------------
        */

		if ($user->isManagement()) {

			$employeeQuery->where(
				'department_id',
				$employee->department_id
			);
		}


		/*
        |--------------------------------------------------------------------------
        | Staff
        |--------------------------------------------------------------------------
        */

		if ($user->isStaff()) {

			$employeeQuery->where(
				'id',
				$employee->id
			);
		}


		/*
        |--------------------------------------------------------------------------
        | Employee Statistics
        |--------------------------------------------------------------------------
        */

		$employeeStats = [

			'total' => (clone $employeeQuery)
				->count(),

			'active' => (clone $employeeQuery)
				->where(
					'status',
					'active'
				)
				->count(),

			'manager' => (clone $employeeQuery)
				->whereHas(
					'position.role',
					function ($query) {
						$query->where(
							'name',
							'manager'
						);
					}
				)
				->count(),

			'supervisor' => (clone $employeeQuery)
				->whereHas(
					'position.role',
					function ($query) {
						$query->where(
							'name',
							'supervisor'
						);
					}
				)
				->count(),

			'staff' => (clone $employeeQuery)
				->whereHas(
					'position.role',
					function ($query) {
						$query->where(
							'name',
							'staff'
						);
					}
				)
				->count(),
		];


		/*
        |--------------------------------------------------------------------------
        | Employee List
        |--------------------------------------------------------------------------
        */

		$employees = (clone $employeeQuery)
			->orderBy('name')
			->limit(6)
			->get();


		/*
        |--------------------------------------------------------------------------
        | Task Statistics
        |--------------------------------------------------------------------------
        */

		$taskStats = [

			'total' => (clone $taskBaseQuery)
				->count(),

			'not_started' => (clone $taskBaseQuery)
				->whereHas(
					'status',
					function ($query) {

						$query->where(
							'code',
							'not_started'
						);
					}
				)
				->count(),

			'in_progress' => (clone $taskBaseQuery)
				->whereHas(
					'status',
					function ($query) {

						$query->where(
							'code',
							'in_progress'
						);
					}
				)
				->count(),

			'completed' => (clone $taskBaseQuery)
				->whereHas(
					'status',
					function ($query) {

						$query->where(
							'code',
							'completed'
						);
					}
				)
				->count(),

			'overdue' => (clone $taskBaseQuery)
				->whereDate(
					'deadline',
					'<',
					today()
				)
				->whereHas(
					'status',
					function ($query) {

						$query->where(
							'code',
							'!=',
							'completed'
						);
					}
				)
				->count(),
		];


		/*
        |--------------------------------------------------------------------------
        | Task Completion Percentage
        |--------------------------------------------------------------------------
        */

		$taskProgress = $taskStats['total'] > 0
			? round(
				(
					$taskStats['completed']
					/
					$taskStats['total']
				) * 100
			)
			: 0;


		/*
        |--------------------------------------------------------------------------
        | Upcoming Deadline
        |--------------------------------------------------------------------------
        */

		$upcomingTasks = Task::query()
			->visibleTo($user)
			->with([
				'pic',
				'priority',
				'status',
			])
			->whereDate(
				'deadline',
				'>=',
				today()
			)
			->whereHas(
				'status',
				function ($query) {

					$query->where(
						'code',
						'!=',
						'completed'
					);
				}
			)
			->orderBy('deadline')
			->limit(5)
			->get();


		/*
        |--------------------------------------------------------------------------
        | Recent Tasks
        |--------------------------------------------------------------------------
        */

		$recentTasks = Task::query()
			->visibleTo($user)
			->with([
				'pic',
				'priority',
				'status',
			])
			->latest()
			->limit(5)
			->get();


		return view(
			'dashboard',
			compact(
				'user',
				'employee',
				'employeeStats',
				'employees',
				'taskStats',
				'taskProgress',
				'upcomingTasks',
				'recentTasks'
			)
		);
	}
}
