<?php

namespace App\Repositories;

use App\Enums\UserGuard;
use App\Interfaces\PostInterface;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class PostRepository extends BaseRepository implements PostInterface
{
    /**
     * Setup the repository.
     *
     * @param \App\Models\Post $model
     */
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    /**
     * {@inheritDoc}
     */
    public function getUserPost($id): Collection
    {
        return $this->model
            ->where('user_id', $id)
            ->with([
                'user',
                'media',
                'comments.user',
                'comments.replies',
                'likes.user'
            ])
            ->latest()
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getFriendsPost(array $friendsIds): Collection
    {
        return $this->model
            ->whereIn('user_id', $friendsIds)
            ->with([
                'user',
                'media',
                'comments.user',
                'comments.replies',
                'likes.user'
            ])
            ->latest()
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getHomePosts(int $userId, array $friendsIds): Collection
    {
        $posts = $this->model
            ->where('user_id', $userId)
            ->orWhereIn('user_id', $friendsIds)
            ->with([
                'user',
                'media',
                'comments.user',
                'comments.replies',
                'likes.user',
            ])
            ->latest()
            ->get();

        $authUser = auth()->guard(UserGuard::USER->value)->user();
        $authUserId = $authUser?->id;

        // Add is_liked status for the authenticated user
        $posts->each(function ($post) use ($authUserId) {
            /** @var \App\Models\Post $post */
            $post->is_liked = $post->likes->where('user_id', $authUserId)->isNotEmpty();
        });

        // Add is_liked status for the authenticated user on posts, comments, and replies
        $posts->each(function ($post) use ($authUserId) {
            /** @var \App\Models\Post $post */
            $post->is_liked = $post->likes->where('user_id', $authUserId)->isNotEmpty();

            $post->comments->each(function ($comment) use ($authUserId) {
                /** @var \App\Models\Comment $comment */
                $comment->is_liked = $comment->likes->where('user_id', $authUserId)->isNotEmpty();

                $comment->replies->each(function ($reply) use ($authUserId) {
                    /** @var \App\Models\Comment $reply */
                    $reply->is_liked = $reply->likes->where('user_id', $authUserId)->isNotEmpty();
                });
            });
        });

        return $posts;
    }
}
