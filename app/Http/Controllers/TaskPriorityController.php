<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskPriorityRequest;
use App\Http\Requests\UpdateTaskPriorityRequest;
use App\Models\TaskPriority;
use Illuminate\Http\Request;

class TaskPriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TaskPriority::query();

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($query) use ($search) {

                $query->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $taskPriorities = $query
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(
                $request->integer('per_page', 10)
            )
            ->withQueryString();

        return view(
            'task-priorities.index',
            compact('taskPriorities')
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
    public function store(StoreTaskPriorityRequest $request)
    {
        TaskPriority::create($request->validated());

        return redirect()->route('task-priorities.index')->with('success', 'Prioritas tugas berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskPriority $taskPriority)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskPriority $taskPriority)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskPriorityRequest $request, TaskPriority $taskPriority)
    {
        $taskPriority->update($request->validated());

        return redirect()->route('task-priorities.index')->with('success', 'Prioritas tugas berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskPriority $taskPriority)
    {
        if ($taskPriority->tasks()->exists()) {
            return redirect()->route('task-priorities.index')->with('error', 'Prioritas tugas tidak dapat dihapus karena masih digunakan pada tugas.');
        }

        $taskPriority->delete();

        return redirect()->route('task-priorities.index')->with('success', 'Prioritas tugas berhasil dihapus!');
    }
}
