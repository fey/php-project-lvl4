<?php

use App\Task;
use App\User;

if (!function_exists('getTaskAssignee')) {
    function getTaskAssignee(Task $task): User
    {
        return $task->assignee ?? new User([
            'name' =>  __('layout.task.unassigned')
        ]);
    }
}
