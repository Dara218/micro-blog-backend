<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface CommentInterface extends BaseInterface
{
    /**
     * Get all the comments of a comment by parent comment id.
     *
     * @param int $id The parent comment id (comments.parent_comment_id)
     *
     * @return \Illuminate\Database\Eloquent\Collection A collection of Post models.
     */
    public function getCommentsByParentId(int $id);
}
