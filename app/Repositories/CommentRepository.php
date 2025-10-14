<?php

namespace App\Repositories;

use App\Interfaces\CommentInterface;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

class CommentRepository extends BaseRepository implements CommentInterface
{
    /**
     * Setup the repository.
     *
     * @param \App\Models\Comment $model
     */
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    /**
     * {@inheritDoc}
     */
    public function getCommentsByParentId(int $id)
    {
        return $this->model
            ->where('parent_comment_id', $id)
            ->with('user', 'replies')
            ->get();
    }
}
