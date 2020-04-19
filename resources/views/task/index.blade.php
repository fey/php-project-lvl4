@extends('layouts.app')
@php
/**
 * @var \Illuminate\Support\Collection|\App\Task[] $tasks
 * @var \Illuminate\Support\Collection|\App\User[] $users
 * @var \Illuminate\Support\Collection $taskStatuses
 */
@endphp
@section('content')
    <div class="container">
        <h1>@lang('layout.tasks')</h1>
        <div class="d-flex mb-2">
            @auth
            <p><a class="btn btn-success" href="{{ route('tasks.create') }}">@lang('layout.common.buttons.create')</a></p>
            @endauth
            <div class="ml-auto">
                {!! Form::open()->get()->formInline(__('layout.common.task_status')) !!}
                    {!! Form::select('filter[status_id]', null, $taskStatuses)->attrs(['mr-2']) !!}
                    {!! Form::select('filter[created_by_id]', null, $creators)->attrs(['mr-2']) !!}
                    {!! Form::select('filter[assigned_to_id]', null, $assigns)->attrs(['mr-2']) !!}
                    {!! Form::submit(__('layout.task.filter.apply'))->outline()->attrs(['mr-2']) !!}
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">@lang('layout.task.filter.reset')</a>
                {!! Form::close() !!}
            </div>
        </div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">@lang('layout.common.task_status')</th>
                    <th scope="col">@lang('layout.common.name')</th>
                    <th scope="col">@lang('layout.task.creator')</th>
                    <th scope="col">@lang('layout.task.assignee')</th>
                    <th scope="col">@lang('layout.common.created_at')</th>
                    @auth
                    <th scope="col">@lang('layout.common.actions')</th>
                    @endauth
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->status->name }}</td>
                        <td>
                            <a href="{{ route('tasks.show', $task) }}">{{ $task->name }}</a>
                            @foreach($task->labels as $label)
                            <span class="badge badge-pill badge-primary">{{ $label->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $task->creator->name }}</td>
                        <td>{{ getTaskAssignee($task)->name }}</td>
                        <td>{{ $task->created_at }}</td>
                        <td>
                        @auth
                            <a href="{{ route('tasks.edit', $task) }}">@lang('layout.common.edit')</a>
                            @can('delete', $task)
                            <a href="{{ route('tasks.destroy', $task) }}" class="text-danger"
                               data-confirm="@lang('layout.common.confirm_destroy')" data-method="delete"
                               rel="nofollow">
                                @lang('layout.common.destroy')
                            </a>
                            @endcan
                        @endauth
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
@endsection
