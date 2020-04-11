@extends('layouts.app')
@php
/**
 * @var \Illuminate\Support\Collection|\App\Label[] $labels
 */
@endphp
@section('content')
    <div class="container">
        <p>
            <a class="btn btn-success" href="{{ route('labels.create') }}">@lang('create')</a>
        </p>
        <div class="row justify-content-center">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">@lang('name')</th>
                    <th scope="col">@lang('created_at')</th>
                    @auth
                    <th scope="col">@lang('actions')</th>
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
                            <a href="{{ route('task_statuses.edit', $taskStatus) }}">@lang('edit')</a>
                            <a href="{{ route('task_statuses.destroy', $taskStatus) }}"
                               class="text-danger"
                               data-confirm="Вы уверены?"
                               data-method="delete"
                               rel="nofollow">
                                @lang('destroy')
                            </a>
                            @endauth
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
