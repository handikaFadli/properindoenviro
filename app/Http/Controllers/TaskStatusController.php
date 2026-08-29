<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskStatusRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Models\TaskStatus;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TaskStatus::query();

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($query) use ($search) {
                $query->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $taskStatuses = $query
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(
                $request->integer('per_page', 10)
            )
            ->withQueryString();

        return view(
            'task-statuses.index',
            compact('taskStatuses')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskStatusRequest $request)
    {
        TaskStatus::create($request->validated());

        return redirect()->route('task-statuses.index')->with('success', 'Status tugas berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskStatus $taskStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskStatus $taskStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskStatusRequest $request, TaskStatus $taskStatus)
    {
        $taskStatus->update($request->validated());

        return redirect()->route('task-statuses.index')->with('success', 'Status tugas berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskStatus $taskStatus)
    {
        if ($taskStatus->tasks()->exists() || $taskStatus->histories()->exists()) {
            return redirect()->route('task-statuses.index')->with('error', 'Status tugas tidak dapat dihapus karena masih digunakan pada tugas.');
        }

        $taskStatus->delete();

        return redirect()->route('task-statuses.index')->with('success', 'Status tugas berhasil dihapus!');
    }
}
