@extends('layouts.app')

@section('content')
<div class="container">
    <div class="jumbotron mt-3">
        <h1>@lang('layout.task_manager')</h1>
        <p class="lead">@lang('layout.home.description')</p>
        <a class="btn btn-lg btn-primary" href="{{ route('tasks.index') }}" role="button">@lang('layout.home.view_tasks') »</a>
    </div>
</div>
@endsection
