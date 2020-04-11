<?php

namespace App\Http\Controllers;

use App\TaskStatus;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }

    public function index()
    {
        $taskStatuses = TaskStatus::all();

        return view('task_status.index', compact('taskStatuses'));
    }

    public function create()
    {
        $taskStatus = new TaskStatus();

        return view('task_status.create', compact('taskStatus'));
    }

    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required']);
        $taskStatus = new TaskStatus();

        $taskStatus->name = $request->input('name');
        $taskStatus->saveOrFail();
        flash()->success(__('flash.success'));
        return redirect()->route('task_statuses.index');
    }

    public function show()
    {
        return abort(404);
    }

    public function edit(TaskStatus $taskStatus)
    {
        return view('task_status.edit', compact('taskStatus'));
    }

    public function update(Request $request, TaskStatus $taskStatus)
    {
        $this->validate($request, ['name' => 'required']);
        $taskStatus->name = $request->input('name');
        $taskStatus->saveOrFail();
        flash()->success(__('flash.success'));

        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        if ($taskStatus->tasks()->exists()) {
            flash()->error('status_has_tasks');
            return back();
        }
        $taskStatus->delete();
        flash()->success(__('flash.success'));

        return back();
    }
}
