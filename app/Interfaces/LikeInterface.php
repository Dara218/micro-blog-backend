<?php

namespace App\Interfaces;

interface LikeInterface extends BaseInterface
{
    /**
     * Get a like record by likeable ID and user ID.
     *
     * @param int $id The likeable id (likes.likeable_id)
     * @param int $userId The user id (likes.user_id)
     * @param string $likeableType The likeable type (likes.likeable_type)
     *
     * @return mixed The like model instance or null if not found.
     */
    public function getByUserIdAndLikeableId(int $id, int $userId, string $likeableType);

    /**
     * Get a like record by post ID and user ID.
     * @deprecated Use getByUserIdAndLikeableId instead
     *
     * @param int $id The post id (likes.likeable_id)
     * @param int $userId The user id (likes.user_id)
     *
     * @return mixed The like model instance or null if not found.
     */
    public function getByUserIdAndPostId(int $id, int $userId);

    /**
     * Restore a soft-deleted like record.
     *
     * @param int $id The like id (likes.id)
     *
     * @return bool True if the like was restored, false otherwise.
     */
    public function restoreLike(int $id);
}
