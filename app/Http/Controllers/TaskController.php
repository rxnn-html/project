<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // View Tasks: show all tasks
    public function index()
    {
        $tasks = Task::orderBy('due_date')->get();

        return view('tasks.index', compact('tasks'));
    }

    // Show the form for creating a new task
    public function create()
    {
        return view('tasks.create');
    }

    // Add Task: validate input and store a new task
    public function store(Request $request)
    {
        // Fixed validation rules matching your form inputs (title, priority, status, due_date)
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority'    => 'required|string',
            'status'      => 'required|string',
            'due_date'    => 'required|date',
        ]);

        Task::create($validated);

        // If requested via AJAX/Fetch, return JSON so the frontend handles it cleanly
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Task added successfully.']);
        }

        return redirect()->route('tasks.index')->with('success', 'Task added successfully.');
    }

    // Show the form for editing an existing task
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // Edit Task: validate input and update the task
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority'    => 'required|string',
            'status'      => 'required|string',
            'due_date'    => 'required|date',
        ]);

        $task->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Task updated successfully.']);
        }

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    // Delete Task: remove it from the database
    public function destroy(Request $request, Task $task)
    {
        $task->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Task deleted successfully.']);
        }

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    // Update Status: quick toggle between pending and completed
    public function updateStatus(Request $request, Task $task)
    {
        $task->status = strtolower($task->status) === 'pending' ? 'completed' : 'pending';
        $task->save();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Task status updated.']);
        }

        return redirect()->route('tasks.index')->with('success', 'Task status updated.');
    }
}