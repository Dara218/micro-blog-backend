<?php

namespace App\Providers;

use App\Interfaces\{
    FollowInterface,
    PostInterface,
    PostMediaInterface,
    UserInterface,
};
use App\Repositories\{
    FollowRepository,
    PostMediaRepository,
    PostRepository,
    UserRepository,
};
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            PostInterface::class,
            PostRepository::class,
        );
        $this->app->bind(
            UserInterface::class,
            UserRepository::class,
        );
        $this->app->bind(
            FollowInterface::class,
            FollowRepository::class,
        );
        $this->app->bind(
            PostMediaInterface::class,
            PostMediaRepository::class,
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
