@extends('layouts.app')
@php
/**
 * @var \Illuminate\Support\Collection|\App\TaskStatus[] $taskStatuses
 */
@endphp
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">@lang('name')</th>
                    <th scope="col">@lang('created_at')</th>
                    <th scope="col">@lang('actions')</th>
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
                            <a href="{{ route('task_statuses.show', $taskStatus) }}">@lang('show')</a>
                            <a href="{{ route('task_statuses.edit', $taskStatus) }}">@lang('edit')</a>
                            <a href="{{ route('task_statuses.destroy', $taskStatus) }}" class="text-danger">@lang('destroy')</a>
                            @endauth
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
