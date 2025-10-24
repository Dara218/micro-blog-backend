<?php

namespace App\Services\Like;

use App\Interfaces\{
    LikeInterface,
    PostInterface,
};

class LikeService
{
    /**
     * LikeInterface instance.
     *
     * @var \App\Interfaces\LikeInterface $likeInterface
     */
    protected LikeInterface $likeInterface;

    /**
     * PostInterface instance.
     *
     * @var \App\Interfaces\PostInterface $postInterface
     */
    protected PostInterface $postInterface;

    /**
     * Setup the service.
     *
     * @param \App\Interfaces\LikeInterface $likeInterface
     * @param \App\Interfaces\PostInterface $postInterface
     */
    public function __construct(LikeInterface $likeInterface, PostInterface $postInterface)
    {
        $this->likeInterface = $likeInterface;
        $this->postInterface = $postInterface;
    }

    /**
     * Handle the like/unlike action for a post.
     * Creates a new like, restores a soft-deleted like, or unlikes the post.
     *
     * @param array<string, mixed> $data The like data (likeable_id, user_id, likeable_type)
     *
     * @return void
     *
     * @throws \Exception
     */
    public function handleLikePost(array $data): void
    {
        try {
            $like = $this->likeInterface->getByUserIdAndPostId(
                $data['likeable_id'],
                $data['user_id'],
            );

            $post = $this->postInterface->find($data['likeable_id']);

            // If first time liking the post
            if (!$like) {
                $this->likeInterface->create($data);

                $post->increment('like_count');

                return;
            }

            // If re-liking the post
            if ($like->trashed()) {
                $this->likeInterface->restoreLike($like->id);

                $post->increment('like_count');

                return;
            }

            $post->decrement('like_count');

            // Unlike the post
            $this->likeInterface->delete($like->id);
        } catch (\Exception $error) {
            throw $error;
        }
    }
}
