@extends('layouts.app')
@php
/**
 * @var \App\Task $task
 * @var \Illuminate\Support\Collection $taskStatuses
 */
@endphp
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            {!! Form::model($task, ['url' => route('tasks.store', $task), 'method' => 'POST']) !!}
            <div class="form-group">
                {!! Form::label('name', __('name')) !!}
                {!! Form::text('name', '', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', __('description')) !!}
                {!! Form::textarea('description', '', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('status_id', __('status')) !!}
                {!! Form::select('status_id', $taskStatuses, null, ['class' => 'form-control']) !!}
            </div>
            {!! Form::token() !!}
            {!! Form::submit(null, ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
