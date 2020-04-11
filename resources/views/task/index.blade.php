@extends('layouts.app')
@php
/**
 * @var \Illuminate\Support\Collection|\App\Task[] $tasks
 */
@endphp
@section('content')
    <div class="container">
        @auth
        <p>
            <a class="btn btn-success" href="{{ route('tasks.create') }}">@lang('create')</a>
        </p>
        @endauth
        <div class="row justify-content-center">

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">@lang('status')</th>
                    <th scope="col">@lang('name')</th>
                    <th scope="col">@lang('creator')</th>
                    <th scope="col">@lang('assignee')</th>
                    <th scope="col">@lang('created_at')</th>
                    @auth
                    <th scope="col">@lang('actions')</th>
                    @endauth
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->status_id }}</td>
                        <td><a href="{{ route('tasks.show', $task) }}">{{ $task->name }}</a></td>
                        <td>{{ $task->creator->name }}</td>
                        <td>{{ $task->assignee->name }}</td>
                        <td>{{ $task->created_at }}</td>
                        <td>
                        @auth
                            <a href="{{ route('tasks.edit', $task) }}">@lang('edit')</a>
                            @if((string)auth()->id() === (string)$task->created_by_id)
                            <a href="{{ route('tasks.destroy', $task) }}"
                               class="text-danger"
                               data-confirm="Вы уверены?"
                               data-method="delete"
                               rel="nofollow">
                                @lang('destroy')
                            </a>
                            @endif
                        @endauth
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
