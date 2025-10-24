<?php

namespace App\Providers;

use App\Interfaces\{
    CommentInterface,
    FollowInterface,
    LikeInterface,
    PostInterface,
    PostMediaInterface,
    UserInterface,
};
use App\Repositories\{
    CommentRepository,
    FollowRepository,
    PostMediaRepository,
    PostRepository,
    UserRepository,
};
use App\Repositories\LikeRepostitory;
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
        $this->app->bind(
            CommentInterface::class,
            CommentRepository::class,
        );
        $this->app->bind(
            LikeInterface::class,
            LikeRepostitory::class,
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
