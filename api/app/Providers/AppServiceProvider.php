<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            \App\Exceptions\Handler::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\User\UserContract::class,
            \App\Repositories\Eloquent\User\UserRepository::class,
        );

        $this->app->bind(
            \App\Repositories\Interfaces\Goal\GoalContract::class,
            \App\Repositories\Eloquent\Goal\GoalRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
