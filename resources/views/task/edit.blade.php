@extends('layouts.app')
@php
/**
* @var \App\Task $task
*/
@endphp
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-md-8">
                <div class="card-body">
                    <h1 class="card-title">@lang('layout.task.form.edit_title')</h1>
                    {!! Form::model($task, ['url' => route('tasks.update', $task), 'method' => 'PATCH']) !!}
                    @include('task._form')
                    {!! Form::submit(__('task.form.save'), ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

