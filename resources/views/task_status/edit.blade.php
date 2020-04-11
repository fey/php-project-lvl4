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
                    {!! Form::model($taskStatus, ['url' => route('task_statuses.update', $taskStatus), 'method' => 'PATCH']) !!}
                    @include('task_status._form')
                    {!! Form::submit(null, ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
