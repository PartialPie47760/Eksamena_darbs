<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\Task;
use App\Policies\TaskPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Task::class => TaskPolicy::class,
    ];

    public function boot(): void
{
    Paginator::useTailwind();

    
    Gate::define('isAdmin', function (User $user) {
        return $user->isAdmin();
    });

    
    Gate::define('assignUser', function (User $user) {
        return $user->isSupremeUser() || $user->isAdmin();
    });
}
}
