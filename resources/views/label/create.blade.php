@extends('layouts.app')
@php
/**
 * @var \App\Label $label
 */
@endphp
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-md-8">
                <div class="card-body">
                    <h1 class="card-title">@lang('label.create')</h1>
                    {!! Form::open()->fill($label)->route('labels.store', [$label])->locale('layout.label.form') !!}
                    @include('label._form')
                    {!! Form::submit(__('layout.common.buttons.create')) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
