@php
/**
 * @var \App\Label $label
 */
@endphp
<div class="form-group">
    {!! Form::label('name', __('name'), ['class' => 'required']) !!}
    {!! Form::text('name', null, ['required', 'placeholder' => __('enter_name'), 'class' => collect([
        'form-control',
        $errors->has('name') ? 'is-invalid' : ''
    ])->filter()->implode(' ')]) !!}
    @error('name')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
{!! Form::token() !!}
