<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskPriorityController;
use App\Http\Controllers\TaskStatusController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get(
        '/',
        [
            DashboardController::class,
            'index'
        ]
    )->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('departments', DepartmentController::class);
    Route::resource('positions', PositionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('task-statuses', TaskStatusController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('task-priorities', TaskPriorityController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::get('employees/export/{format}', [EmployeeController::class, 'export'])
        ->whereIn('format', ['xlsx', 'csv', 'pdf'])
        ->name('employees.export');
    Route::resource('employees', EmployeeController::class);
    Route::resource('tasks', TaskController::class);
    Route::patch('/tasks/{task}/assign-pic', [
        TaskController::class,
        'assignPic'
    ])->name('tasks.assign-pic');

    Route::patch('/tasks/{task}/status', [
        TaskController::class,
        'updateStatus'
    ])->name('tasks.update-status');
});
