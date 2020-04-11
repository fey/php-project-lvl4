@extends('layouts.app')
@php
/**
* @var \App\Task $task
*/
@endphp
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            {!! Form::model($task, ['url' => route('tasks.store', $task), 'method' => 'POST']) !!}
                @include('task._form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
