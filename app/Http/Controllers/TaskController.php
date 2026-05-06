<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
{
    $tasks = Task::with('user')->get();
    return response()->json($tasks);
}

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:pending,in_progress,completed',
            'priority' => 'in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);

        $task = Task::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? 'pending',
            'priority' => $request->priority ?? 'medium',
            'due_date' => $request->due_date,
        ]);

        return response()->json($task, 201);
    }

    public function show(Request $request, $id)
    {
        $task = Task::where('id', $id)->where('user_id', $request->user()->id)->firstOrFail();
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $task = Task::where('id', $id)->where('user_id', $request->user()->id)->firstOrFail();
        $task->update($request->all());
        return response()->json($task);
    }

    public function destroy(Request $request, $id)
    {
        $task = Task::where('id', $id)->where('user_id', $request->user()->id)->firstOrFail();
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
}