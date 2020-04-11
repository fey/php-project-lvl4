@extends('layouts.app')
@php
/**
 * @var \Illuminate\Support\Collection|\App\TaskStatus[] $taskStatuses
 */
@endphp
@section('content')
    <div class="container">
        <h1>@lang('layout.task_statuses')</h1>
        @auth
        <p>
            <a class="btn btn-success" href="{{ route('task_statuses.create') }}">@lang('layout.common.buttons.create')</a>
        </p>
        @endauth
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">@lang('layout.common.name')</th>
                    <th scope="col">@lang('layout.common.created_at')</th>
                    @auth
                    <th scope="col">@lang('layout.common.actions')</th>
                    @endauth
                </tr>
                </thead>
                <tbody>
                @foreach($taskStatuses as $taskStatus)
                    <tr>
                        <td>{{ $taskStatus->id }}</td>
                        <td>{{ $taskStatus->name }}</td>
                        <td>{{ $taskStatus->created_at }}</td>
                        <td>
                            @auth
                            <a href="{{ route('task_statuses.edit', $taskStatus) }}">@lang('layout.common.edit')</a>
                            <a href="{{ route('task_statuses.destroy', $taskStatus) }}"
                               class="text-danger"
                               data-confirm="@lang('layout.common.confirm_destroy')"
                               data-method="delete"
                               rel="nofollow">
                                @lang('layout.common.destroy')
                            </a>
                            @endauth
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
@endsection
