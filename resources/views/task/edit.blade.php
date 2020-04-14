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
                    {!! Form::open()->fill($task)->patch()->route('tasks.update', [$task])->locale('layout.task.form') !!}
                    @include('task._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

