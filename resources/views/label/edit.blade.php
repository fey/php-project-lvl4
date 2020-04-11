@extends('layouts.app')
@php
/**
 * @var \App\Label $label
 */
@endphp
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card w-50 min">
                <div class="card-body">
                    <h1 class="card-title">@lang('label.edit')</h1>
                    {!! Form::model($label, ['url' => route('labels.update', $label), 'method' => 'PATCH']) !!}
                    @include('label._form')
                    {!! Form::submit(null, ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
