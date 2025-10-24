<?php

namespace App\Providers;

use App\Models\{
    Comment,
    Post,
};
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('Helpers/FileHelper.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configure morph map for polymorphic relationships
        Relation::morphMap([
            'post' => Post::class,
            'comment' => Comment::class,
        ]);
    }
}
