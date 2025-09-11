<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface FollowInterface extends BaseInterface
{
    /**
     * Get the users being followed by the user.
     *
     * @param int $userId The user id (followers.follower_id)
     *
     * @return \Illuminate\Database\Eloquent\Collection A collection of Follow models.
     */
    public function getUserFollowing(int $userId): Collection;

    /**
     * Get the users following the user.
     *
     * @param int $userId The user id (followers.followed_id)
     *
     * @return \Illuminate\Database\Eloquent\Collection A collection of Follow models.
     */
    public function getUserFollowers(int $userId): Collection;
}
