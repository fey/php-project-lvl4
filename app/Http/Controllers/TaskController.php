<?php

namespace App\Http\Controllers;

use App\Task;
use App\TaskStatus;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $tasks = Task::all();

        return view('task.index', compact('tasks'));
    }

    public function create()
    {
        $task = new Task();
        $taskStatuses = TaskStatus::all()
            ->mapWithKeys(fn(TaskStatus $taskStatus) => [
                $taskStatus->id => $taskStatus->name
            ]);

        return view('task.create', compact('task', 'taskStatuses'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'nullable|string',
            'status_id' => 'required|integer',
            'assigned_to_id' => 'nullable|integer'
        ]);

        $task = new Task();
        $task->created_by_id = auth()->id();

        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->status_id = $request->input('status_id', 1);
        $task->assigned_to_id = $request->input('assigned_to_id');

        $task->saveOrFail();

        flash()->success(__('flash.success'));

        return redirect()->route('tasks.show', $task);
    }

    public function show(Task $task)
    {
        return view('task.show', compact('task'));
    }

    public function edit(Task $task)
    {
        return view('task.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'nullable|string',
            'status_id' => 'required|integer',
            'assigned_to_id' => 'nullable|integer'
        ]);

        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->status_id = $request->input('status_id', 1);
        $task->assigned_to_id = $request->input('assigned_to_id');

        $task->saveOrFail();

        flash()->success(__('flash.success'));

        return redirect()->route('tasks.show', $task);
    }

    public function destroy(Task $task)
    {
        abort_if((string)$task->created_by_id !== (string)auth()->id(), 403);

        $task->delete();
        flash()->success(__('flash.success'));

        return redirect()->route('tasks.index');
    }
}
