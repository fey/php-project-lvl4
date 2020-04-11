@extends('layouts.app')
@php
/**
 * @var \App\Label $label
 */
@endphp
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            {!! Form::model($label, ['url' => route('labels.update', $label), 'method' => 'PATCH']) !!}
            {!! Form::label('name', __('name'), ['class' => 'required']) !!}
            {!! Form::text('name') !!}
            {!! Form::token() !!}
            {!! Form::submit() !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
