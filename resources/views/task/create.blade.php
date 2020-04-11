@extends('layouts.app')
@php
/**
* @var \App\Task $task
*/
@endphp
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card w-50 min">
                <div class="card-body">
                    <h1 class="card-title">@lang('layout.task.form.create_title')</h1>
                    {!! Form::model($task, ['url' => route('tasks.store', $task), 'method' => 'POST']) !!}
                    @include('task._form')
                    {!! Form::submit(__('task.form.create'), ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
