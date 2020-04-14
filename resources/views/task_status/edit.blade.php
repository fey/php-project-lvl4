@extends('layouts.app')
@php
/**
 * @var \App\TaskStatus $taskStatus
 */
@endphp
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-md-8">
                <div class="card-body">
                    <h1 class="card-title">@lang('layout.task_status.form.edit_title')</h1>
                    {!! Form::open()->patch()->fill($taskStatus)->route('task_statuses.update', [$taskStatus])->locale('layout.label.form') !!}
                    @include('label._form')
                    {!! Form::submit(__('layout.common.buttons.save'))->success() !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
