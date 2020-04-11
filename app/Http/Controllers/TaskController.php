<?php

namespace App\Http\Controllers;

use App\Label;
use App\Task;
use App\TaskStatus;
use App\User;
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

        $labels = Label::all();
        $taskStatuses = TaskStatus::all()
            ->mapWithKeys(fn(TaskStatus $taskStatus) => [
                $taskStatus->id => $taskStatus->name
            ]);
        $users = User::all()
            ->mapWithKeys(fn(User $user) => [
                $user->id => $user->name
            ]);

        $view = view('task.create', compact('task', 'taskStatuses', 'labels', 'users'));

        if ($taskStatuses->isEmpty()) {
            return $view->withErrors([
                'empty_statuses' => __('empty_statuses')
            ]);
        }

        return $view;
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

        $task->name = $request->input('name');
        $task->description = $request->input('description');

        $task->status()->associate($request->input('status_id', 1));
        $task->creator()->associate(auth()->user());
        $task->assignee()->associate($request->input('assigned_to_id'));

        $task->saveOrFail();
        $task->labels()->attach($request->input('labels'));

        flash()->success(__('flash.success'));

        return redirect()->route('tasks.show', $task);
    }

    public function show(Task $task)
    {
        return view('task.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $labels = Label::all();

        $taskStatuses = TaskStatus::all()
            ->mapWithKeys(fn(TaskStatus $taskStatus) => [
                $taskStatus->id => $taskStatus->name
            ]);
        $users = User::all()
            ->mapWithKeys(fn(User $user) => [
                $user->id => $user->name
            ]);

        return view('task.edit', compact('task', 'labels', 'taskStatuses', 'users'));
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

        $task->status()->associate($request->input('status_id', 1));
        $task->creator()->associate(auth()->user());
        $task->assignee()->associate($request->input('assigned_to_id'));

        $task->saveOrFail();
        $task->labels()->sync($request->input('labels'));

        flash()->success(__('flash.success'));

        return redirect()->route('tasks.show', $task);
    }

    public function destroy(Task $task)
    {
        abort_if((string)$task->created_by_id !== (string)auth()->id(), 403);

        $task->labels()->detach();
        $task->delete();
        flash()->success(__('flash.success'));

        return redirect()->route('tasks.index');
    }
}
