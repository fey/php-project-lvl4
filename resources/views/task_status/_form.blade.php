@php
/**
 * @var \App\TaskStatus $taskStatus
 */
@endphp
<div class="form-group">
    {!! Form::label('name', __('layout.task_status.form.name'), ['class' => 'required']) !!}
    {!! Form::text('name', null, ['required', 'placeholder' => __('layout.task_status.form.enter_name'), 'class' => collect([
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
