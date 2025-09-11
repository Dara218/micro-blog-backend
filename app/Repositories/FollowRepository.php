<?php

namespace App\Repositories;

use App\Interfaces\FollowInterface;
use App\Models\Follow;
use Illuminate\Database\Eloquent\Collection;

class FollowRepository extends BaseRepository implements FollowInterface
{
    /**
     * Setup the repository.
     *
     * @param \App\Models\Follow $model
     */
    public function __construct(Follow $model)
    {
        parent::__construct($model);
    }

    /**
     * {@inheritDoc}
     */
    public function getUserFollowing(int $userId): Collection
    {
        return $this->model
            ->where('follower_id', $userId)
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getUserFollowers(int $userId): Collection
    {
        return $this->model
            ->where('followed_id', $userId)
            ->get();
    }
}
