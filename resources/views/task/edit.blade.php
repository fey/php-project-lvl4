@extends('layouts.app')
@php
    /**
     * @var \App\Task $task
     */
@endphp
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            {!! Form::model($task, ['url' => route('tasks.update', $task), 'method' => 'PATCH']) !!}
            {!! Form::label('name', __('name')) !!}
            {!! Form::text('name') !!}
            {!! Form::label('description', __('description')) !!}
            {!! Form::textarea('description') !!}
            {!! Form::token() !!}
            {!! Form::submit() !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
