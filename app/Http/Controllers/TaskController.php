<?php

namespace App\Http\Controllers;

use App\Label;
use App\Task;
use App\TaskStatus;
use App\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $tasks = QueryBuilder::for(Task::class)
            ->with('creator', 'status', 'assignee', 'status', 'labels')
            ->allowedFilters(
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id')
            )
            ->get();

        $taskStatuses = TaskStatus::all()
            ->mapWithKeys(fn(TaskStatus $taskStatus) => [
                $taskStatus->id => $taskStatus->name
            ])
            ->prepend(__('layout.task.form.choose_status'), '');

        $users = User::all()
            ->mapWithKeys(fn(User $user) => [
                $user->id => $user->name
            ]);

        $creators = $users->prepend(__('layout.task.creator'), '');
        $assigns = $users->prepend(__('layout.task.assignee'), '');

        return view('task.index', compact('tasks', 'taskStatuses', 'users', 'creators', 'assigns'));
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

        $task->status()->associate($request->input('status_id'));
        $task->creator()->associate(auth()->user());
        $task->assignee()->associate($request->input('assigned_to_id'));

        $task->saveOrFail();
        $task->labels()->attach($request->input('labels'));

        flash()->success(__('layout.flash.success'));

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

        flash()->success(__('layout.flash.success'));

        return redirect()->route('tasks.show', $task);
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->labels()->detach();
        $task->delete();
        flash()->success(__('layout.flash.success'));

        return redirect()->route('tasks.index');
    }
}
