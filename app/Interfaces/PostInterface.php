<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface PostInterface extends BaseInterface
{
    /**
     * Get the posts of the user.
     *
     * @param mixed $id The user id (posts.user_id)
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserPost($id): Collection;

    /**
     * Retrieve posts made by the user's friends.
     * Filters posts where the user ID matches any of the provided friend IDs.
     *
     * @param array $friendsIds An array of user IDs representing the user's friends.
     *
     * @return \Illuminate\Database\Eloquent\Collection A collection of Post models.
     */
    public function getFriendsPost(array $friendsIds): Collection;

    /**
     * Retrieve posts for the user's home feed.
     *
     * This includes posts made by the user and their friends,
     * ordered by the latest, with associated user data eager-loaded.
     *
     * @param int $userId The ID of the authenticated user.
     * @param array $friendsIds An array of user IDs representing the user's friends.
     *
     * @return \Illuminate\Database\Eloquent\Collection A collection of Post models.
     */
    public function getHomePosts(int $userId, array $friendsIds): Collection;
}
