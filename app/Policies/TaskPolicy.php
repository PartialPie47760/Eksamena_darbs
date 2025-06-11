<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    // Determine whether the user can view any models.
    public function viewAny(User $user): bool
    {
        return true; // only auth. users may withness the tasks
    }

    // Determine whether the user can view the model.
    public function view(User $user, Task $task): bool
    {
        return $user->id === $task->user_id || $user->id === $task->assigned_to_user_id;
    }

    //Determine whether the user can create models.
    public function create(User $user): bool
    {
        return $user->isSupremeUser() || $user->isAdmin();
    }

    //Determine whether the user can update the model.
    public function update(User $user, Task $task): bool
    {
        
        if ($user->id === $task->user_id) {
            return true;
        }

        
        if ($user->id === $task->assigned_to_user_id && $user->isUser()) {
            
            if ($task->status->name === 'Done') { 
                return false;
            }
            
            return true;
        }

        return false;
    }

    //Determine whether the user can delete the model.
    public function delete(User $user, Task $task): bool
    {
        return ($user->isSupremeUser() && $user->id === $task->user_id) || $user->isAdmin();
    }

    
    public function markAsCompleted(User $user, Task $task): bool
    {
        
        if ($user->id === $task->assigned_to_user_id && $user->isUser()) {
            return true;
        }

        
        if (($user->isSupremeUser() || $user->isAdmin()) && $user->id === $task->user_id) {
            return true;
        }

        return false;
    }

    // assign users
    public function assignUser(User $user, Task $task = null): bool
    {
        
        return $user->isSupremeUser() || $user->isAdmin();
    }
}
