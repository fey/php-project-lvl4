<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_label');
    }
}
