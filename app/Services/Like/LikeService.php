<?php

namespace App\Services\Like;

use App\Interfaces\{
    LikeInterface,
    PostInterface,
};
use App\Models\{
    Comment,
    Post,
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
     * Handle the like/unlike action for a post or comment.
     * Creates a new like, restores a soft-deleted like, or unlikes the content.
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
            // Normalize the likeable type for consistent handling
            $normalizedType = $this->normalizeLikeableType($data['likeable_type']);

            $like = $this->likeInterface->getByUserIdAndLikeableId(
                $data['likeable_id'],
                $data['user_id'],
                $normalizedType
            );

            // Get the likeable model (post or comment)
            $likeable = $this->getLikeableModel($data['likeable_type'], $data['likeable_id']);

            // If first time liking the content
            if (!$like) {
                $likeData = $data;
                $likeData['likeable_type'] = $normalizedType;
                $this->likeInterface->create($likeData);

                $likeable->increment('like_count');

                return;
            }

            // If re-liking the content
            if ($like->trashed()) {
                $this->likeInterface->restoreLike($like->id);

                $likeable->increment('like_count');

                return;
            }

            $likeable->decrement('like_count');

            // Unlike the content
            $this->likeInterface->delete($like->id);
        } catch (\Exception $error) {
            throw $error;
        }
    }

    /**
     * Get the likeable model (post or comment) by type and ID.
     *
     * @param string $likeableType The type of likeable model
     * @param int $likeableId The ID of the likeable model
     *
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Exception
     */
    private function getLikeableModel(string $likeableType, int $likeableId)
    {
        // Normalize the likeable type to simple format
        $normalizedType = $this->normalizeLikeableType($likeableType);

        switch ($normalizedType) {
            case 'post':
                $model = Post::find($likeableId);
                if (!$model) {
                    throw new \Exception("Post with ID {$likeableId} not found");
                }
                return $model;
            case 'comment':
                $model = Comment::find($likeableId);
                if (!$model) {
                    throw new \Exception("Comment with ID {$likeableId} not found");
                }
                return $model;
            default:
                throw new \Exception("Unsupported likeable type: {$likeableType}");
        }
    }

    /**
     * Normalize likeable type to simple format.
     *
     * @param string $likeableType The likeable type (short or full)
     *
     * @return string The normalized likeable type
     */
    private function normalizeLikeableType(string $likeableType): string
    {
        // Convert full class names to simple format
        switch ($likeableType) {
            case 'App\Models\Post':
                return 'post';
            case 'App\Models\Comment':
                return 'comment';
            default:
                // Assume it's already in simple format
                return strtolower($likeableType);
        }
    }
}
