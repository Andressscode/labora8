<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $query = Task::with('user', 'etiquetas')->latest();

        if (auth()->check()) {
            $query->where('user_id', auth()->id());
        }

        $tasks = $query->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $users = User::all();
        $etiquetas = Etiqueta::all();
        return view('tasks.create', compact('users', 'etiquetas'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'priority' => 'required|in:baja,media,alta',
            'user_id' => 'nullable|exists:users,id',
            'etiquetas' => 'nullable|array',
            'etiquetas.*' => 'exists:etiquetas,id',
        ]);

        $task = Task::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'priority' => $validatedData['priority'],
            'completed' => false,
            'user_id' => $validatedData['user_id'],
        ]);

        if (isset($validatedData['etiquetas'])) {
            $task->etiquetas()->attach($validatedData['etiquetas']);
        }

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $users = User::all();
        $etiquetas = Etiqueta::all();

        return view('tasks.edit', compact('task', 'etiquetas', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'priority' => 'required|in:baja,media,alta',
            'completed' => 'required|boolean',
            'user_id' => 'nullable|exists:users,id',
            'etiquetas' => 'nullable|array',
            'etiquetas.*' => 'exists:etiquetas,id',
        ]);

        $task->update($validatedData);

        $task->etiquetas()->sync($validatedData['etiquetas'] ?? []);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function complete(Task $task)
    {
        $task->update(['completed' => true]);

        return redirect()->route('tasks.index')->with('success', 'Task marked as completed.');
    }
}