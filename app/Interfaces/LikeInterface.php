<?php

namespace App\Interfaces;

interface LikeInterface extends BaseInterface
{
    /**
     * Get a like record by post ID and user ID.
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
