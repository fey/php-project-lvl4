@php
/**
 * @var \App\Task $task
 * @var \Illuminate\Support\Collection $taskStatuses
 * @var \Illuminate\Support\Collection|\App\Label[] $labels
 * @var \Illuminate\Support\MessageBag $errors
 * @var \Illuminate\Support\Collection|\App\User[] $users
 */
@endphp
{!! Form::text('name', 'name')->placeholder('enter_name') !!}
{!! Form::textarea('description', 'description')->placeholder('enter_description') !!}
{!! Form::select('assigned_to_id', 'assign', $users)->placeholder('assign_to') !!}
{!! Form::select('status_id', 'status', $taskStatuses) !!}
<div class="form-group">
    @foreach($labels as $label)
        {!! Form::checkbox('labels[]', $label->name, $label->id, $taskLabels->has($label->id))->id("label_{$label->id}")->locale('') !!}
    @endforeach
</div>
{!! Form::submit(__('layout.common.buttons.save')) !!}
