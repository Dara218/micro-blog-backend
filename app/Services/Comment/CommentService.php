<?php

namespace App\Services\Comment;

use App\Interfaces\PostInterface;

class CommentService
{
    /**
     * PostInterface instance.
     *
     * @var \App\Interfaces\PostInterface $postInterface
     */
    protected PostInterface $postInterface;

    /**
     * Setup the service.
     *
     * @param \App\Interfaces\PostInterface $postInterface
     */
    public function __construct(PostInterface $postInterface)
    {
        $this->postInterface = $postInterface;
    }

    /**
     * Increments the comment count on the posts table.
     *
     * @param int $postId The id of the post (comments.post_id)
     *
     * @return void
     *
     * @throws \Exception
     */
    public function incrementCommentCount(int $postId): void
    {
        try {
            $post = $this->postInterface->find($postId);

            $post->increment('comment_count');
        } catch (\Exception $error) {
            throw $error;
        }
    }
}
