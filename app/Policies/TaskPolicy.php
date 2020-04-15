<?php

namespace App\Policies;

use App\Task;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Task $task): bool
    {
        return $user->isCreator($task);
    }
}