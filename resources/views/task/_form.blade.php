@php
/**
 * @var \App\Task $task
 * @var \Illuminate\Support\Collection $taskStatuses
 * @var \Illuminate\Support\Collection|\App\Label[] $labels
 * @var \Illuminate\Support\MessageBag $errors
 * @var \Illuminate\Support\Collection|\App\User[] $users
 */
@endphp
<div class="form-group">
    {!! Form::label('name', __('layout.task.form.name'), ['class' => 'required']) !!}
    {!! Form::text('name', null, ['required', 'placeholder' => __('layout.task.form.enter_name'), 'class' => collect([
        'form-control',
        $errors->has('name') ? 'is-invalid' : ''
    ])->filter()->implode(' ')]) !!}
    @error('name')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
<div class="form-group ">
    {!! Form::label('description', __('layout.task.form.description')) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('layout.task.form.enter_description')]) !!}
</div>
<div class="form-group required">
    {!! Form::label('status_id', __('layout.task.form.status'), ['class' => 'required']) !!}
    {!! Form::select('status_id', $taskStatuses, null, ['required', 'placeholder' => __('layout.task.form.choose_status'), 'class' => collect([
        'form-control',
        ($errors->hasAny(['status_id', 'empty_statuses']) ? 'is-invalid' : '')
    ])->filter()->implode(' ')]) !!}
    @error('status_id')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
    @error('empty_statuses')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('assigned_to_id', __('layout.task.form.assign')) !!}
    {!! Form::select('assigned_to_id', $users, $task->assignee->id, ['class' => 'form-control', 'placeholder' => __('layout.task.form.assign_to')]) !!}
</div>
<div class="form-group">
    @foreach($labels as $label)
        <div class="form-check">
            {!! Form::checkbox('labels[]', $label->id, null, ['class' => 'form-check-input', 'id' => "label_{$label->id}"])  !!}
            {!! Form::label("label_{$label->id}", "$label->name", ['class' => 'form-check-label pr-5']) !!}
        </div>
    @endforeach
</div>
{!! Form::token() !!}
