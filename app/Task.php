<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function labels()
    {
        return $this->belongsToMany(Label::class, 'task_label')->withTimestamps();
    }

    public function status()
    {
        return $this->belongsTo(TaskStatus::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to_id')
            ->withDefault([
                'name' => __('layout.task.unassigned')
            ]);
    }
}
