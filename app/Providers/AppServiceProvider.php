<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\Comment;
use App\Policies\TaskPolicy;
use Illuminate\Http\Request;
use App\Policies\CommentPolicy;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Gate;
use App\Repositories\CommentRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use App\Repositories\TaskRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\CommentRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $repositories = [
            UserRepositoryInterface::class => UserRepository::class,
            TaskRepositoryInterface::class => TaskRepository::class,
            CommentRepositoryInterface::class => CommentRepository::class,
        ];
    
        foreach ($repositories as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Task::class, TaskPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
