<?php

use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Like\LikeController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\User\{
    LoginController,
    UserController,
};
use Illuminate\Support\Facades\Route;

Route::get('sanctum/csrf-cookie', fn() => response()->json(['message' => 'CSRF cookie set']));

// User Routes
Route::name('user.')
    ->prefix('user')
    ->group(function() {
        // Guest routes
        Route::post('authenticate', [LoginController::class, 'authenticate'])->name('authenticate');

        // Authenticated routes
        Route::middleware('auth:sanctum')->group(function() {
            // User Routes
            Route::controller(UserController::class)->group(function() {
                Route::get('get-auth', 'getAuthUser')->name('get-auth');
                Route::get('{id}/get-stats', 'getUserStats')->name('get-stats');
            });
        });
    });

// Post Routes
Route::controller(PostController::class)
    ->name('post.')
    ->prefix('post')
    ->middleware('auth:sanctum')
    ->group(function() {
        Route::get('{id}', 'getUserPosts')->name('user');
        Route::get('{id}/friends', 'getFriendsPost')->name('friends');
        Route::get('{id}/home', 'getHomePosts')->name('home');
        Route::post('store', 'store')->name('store');
    });

// Comment Routes
Route::controller(CommentController::class)
    ->name('comment.')
    ->prefix('comment')
    ->group(function() {
        Route::get('{id}/get-comments', 'getCommentByParentId')->name('by-parent-comment');
    });

// Like Routes
Route::controller(LikeController::class)
    ->name('like.')
    ->prefix('like')
    ->group(function() {
        Route::post('process', 'likePost')->name('process]');
        Route::get('get/{id}/{user_id}', 'getByIdAndUserId')->name('getByIdAndUserId');
    });