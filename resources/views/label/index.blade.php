@extends('layouts.app')
@php
/**
 * @var \Illuminate\Support\Collection|\App\Label[] $labels
 */
@endphp
@section('content')
    <div class="container">
        @auth
        <p>
            <a class="btn btn-success" href="{{ route('labels.create') }}">@lang('create')</a>
        </p>
        @endauth
        <div class="row justify-content-center">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">@lang('name')</th>
                    <th scope="col">@lang('created_at')</th>
                    @auth
                    <th scope="col">@lang('actions')</th>
                    @endauth
                </tr>
                </thead>
                <tbody>
                @foreach($labels as $label)
                    <tr>
                        <td>{{ $label->id }}</td>
                        <td>{{ $label->name }}</td>
                        <td>{{ $label->created_at }}</td>
                        <td>
                            @auth
                            <a href="{{ route('labels.edit', $label) }}">@lang('edit')</a>
                            <a href="{{ route('labels.destroy', $label) }}"
                               class="text-danger"
                               data-confirm="Вы уверены?"
                               data-method="delete"
                               rel="nofollow">
                                @lang('destroy')
                            </a>
                            @endauth
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
