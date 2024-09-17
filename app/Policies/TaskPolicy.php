<?php

// namespace App\Policies;

namespace App\Policies;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;

class TaskPolicy
{
    /**admin users can view tasks.
     *
     * @param User $user The user to check permissions for.
     * @return bool True if the user can view tasks, false otherwise.
     */
    public function view(User $user)
    {
       
        return $user->role_user === 'admin';    }
    /**
     * Determine if the given task can be updated by the user.
     * Only manager can update tasks.
     */
    public function update(User $user, Task $task)
    {
       
        return $this->isManager($user, $task->project);

    }

    /**
     * Determine if the user can update task status.
     * Developers can only update the status.
     */
    public function updateStatus(User $user, Task $task)
    {
       
        return $this->isDeveloper($user, $task);
    }

    /**
     * Determine if the user can add a comment.
     * Only tester can add comments.
     */
    public function addComment(User $user, Task $task)
    {
        return $this->isTester($user, $task->project);
    }

    /**
     * Determine if the user can create tasks.
     * Only manager can create tasks.
     */
    public function create(User $user, Project $project)
    {
        return $this->isManager($user, $project);
    }

    /**
     * Determine if the user can delete the task.
     * Only manager can delete tasks.
     */
    public function delete(User $user, Task $task)
    {
        return $this->isManager($user, $task->project);
    }

    protected function isManager(User $user, Project $project)
    {
        return $project->users()->where('user_id', $user->id)->where('role', 'manager')->exists();
    }

    protected function isDeveloper(User $user, Project $project)
    {
        return $project->users()->where('user_id', $user->id)->where('role', 'developer')->exists();
    }

    protected function isTester(User $user, Project $project)
    {
        return $project->users()->where('user_id', $user->id)->where('role', 'tester')->exists();
    }
}
