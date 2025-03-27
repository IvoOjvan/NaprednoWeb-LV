<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;

class TaskPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function destroy(User $user, Task $task)
    {
        return $user->id === $task->user_id;
    }

    public function details(User $user, Task $task)
    {
        $collaborators = explode(',', $task->collaborators);
        return $user->id === $task->user_id || in_array($user->id, $collaborators);
    }
    public function update(User $user, Task $task)
    {
        $collaborators = explode(',', $task->collaborators);
        return $user->id === $task->user_id || in_array($user->id, $collaborators);
    }
    public function store_completed_job(User $user, Task $task)
    {
        $collaborators = explode(',', $task->collaborators);
        return $user->id === $task->user_id || in_array($user->id, $collaborators);
    }
}
