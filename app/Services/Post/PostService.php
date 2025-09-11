<?php

namespace App\Services\Post;

use App\Interfaces\{
    PostInterface,
    UserInterface,
};
use Illuminate\Database\Eloquent\Collection;

class PostService
{
    /**
     * PostInterface instance.
     *
     * @var \App\Interfaces\PostInterface $postInterface
     */
    protected PostInterface $postInterface;

    /**
     * UserInterface instance.
     *
     * @var \App\Interfaces\UserInterface $userInterface
     */
    protected UserInterface $userInterface;

    /**
     * Setup the service.
     *
     * @param \App\Interfaces\PostInterface $postInterface
     * @param \App\Interfaces\UserInterface $userInterface
     */
    public function __construct(PostInterface $postInterface, UserInterface $userInterface)
    {
        $this->postInterface = $postInterface;
        $this->userInterface = $userInterface;
    }

    /**
     * Get the friends Ids.
     *
     * @param int $userId The user's id (posts.user_id)
     *
     * @return mixed
     */
    private function getUserFriendsIds(int $userId)
    {
        // Get the user's friends
        $user = $this->userInterface
            ->find($userId)
            ->load('following');

        // Get the friends Ids
        return $user->following
            ->pluck('followed_id')
            ->toArray();
    }

    /**
     * Get the posts of the user's friends.
     *
     * @param int $userId The user's id (posts.user_id)
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function handleGetFriendPost(int $userId): Collection
    {
        $userFriendIds = $this->getUserFriendsIds($userId);

        return $this->postInterface->getFriendsPost($userFriendIds);
    }

    /**
     * Get all posts for the home page.
     * Includes authenticated user posts + friends posts.
     *
     * @param int $userId The user's id (posts.user_id)
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function handleGetHomePosts(int $userId): Collection
    {
        $userFriendsIds = $this->getUserFriendsIds($userId);

        return $this->postInterface->getHomePosts($userId, $userFriendsIds);
    }
}
