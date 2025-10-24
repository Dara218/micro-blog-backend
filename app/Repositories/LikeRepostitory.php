<?php

namespace App\Repositories;

use App\Interfaces\LikeInterface;
use App\Models\Like;
use Illuminate\Database\Eloquent\Model;

class LikeRepostitory extends BaseRepository implements LikeInterface
{
    /**
     * The Like Model instance.
     *
     * @var \App\Models\Like
     */
    protected Model $model;

    /**
     * Setup the repository.
     *
     * @param \App\Models\Like $model
     */
    public function __construct(Like $model)
    {
        parent::__construct($model);
    }

    /**
     * {@inheritDoc}
     */
    public function getByUserIdAndLikeableId(int $id, int $userId, string $likeableType)
    {
        return $this->model
            ->withTrashed()
            ->where('likeable_id', $id)
            ->where('user_id', $userId)
            ->where('likeable_type', $likeableType)
            ->with('likeable')
            ->first();
    }

    /**
     * {@inheritDoc}
     */
    public function getByUserIdAndPostId(int $id, int $userId)
    {
        return $this->model
            ->withTrashed()
            ->where('likeable_id', $id)
            ->where('user_id', $userId)
            ->where('likeable_type', 'post')
            ->with('likeable')
            ->first();
    }

    /**
     * {@inheritDoc}
     */
    public function restoreLike(int $id)
    {
        $like = $this->model
            ->withTrashed()
            ->find($id);

        if (!$like) {
            return false;
        }

        return $like->restore();
    }
}
