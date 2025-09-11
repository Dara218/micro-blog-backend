<?php

namespace App\Repositories;

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
        return $this->model->where('user_id', $id)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getFriendsPost(array $friendsIds): Collection
    {
        return $this->model
            ->whereIn('user_id', $friendsIds)
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getHomePosts(int $userId, array $friendsIds): Collection
    {
        return $this->model
            ->where('user_id', $userId)
            ->orWhereIn('user_id', $friendsIds)
            ->with('user')
            ->latest()
            ->get();
    }
}
