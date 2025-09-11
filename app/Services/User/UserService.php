<?php

namespace App\Services\User;

use App\Interfaces\{
    FollowInterface,
    PostInterface,
    UserInterface,
};

class UserService
{
    /**
     * UserInterface instance.
     *
     * @var \App\Interfaces\UserInterface $userInterface
     */
    protected UserInterface $userInterface;

    /**
     * PostInterface instance.
     *
     * @var \App\Interfaces\PostInterface $postInterface
     */
    protected PostInterface $postInterface;

    /**
     * FollowInterface instance.
     *
     * @var \App\Interfaces\FollowInterface $followInterface
     */
    protected FollowInterface $followInterface;

    /**
     * Setup the service.
     *
     * @param \App\Interfaces\UserInterface $userInterface
     */
    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
        $this->postInterface = app(PostInterface::class);
        $this->followInterface = app(FollowInterface::class);
    }

    /**
     * Get the user stats.
     * Includes number of posts, followers, and following.
     *
     * @param int $userId The user's id (users.id)
     *
     * @return mixed
     */
    public function handleGetUserStats(int $userId)
    {
        $postsCount = $this->postInterface->getUserPost($userId)->count();
        $followingCount = $this->followInterface->getUserFollowing($userId)->count();
        $followerCount = $this->followInterface->getUserFollowers($userId)->count();

        return [
            'posts_count' => $postsCount,
            'following_count' => $followingCount,
            'follower_count' => $followerCount,
        ];
    }
}
