<?php

namespace App\Repositories;

use App\Interfaces\PostMediaInterface;
use App\Models\PostMedia;

class PostMediaRepository extends BaseRepository implements PostMediaInterface
{
    /**
     * Setup the repository.
     *
     * @param \App\Models\PostMedia $model
     */
    public function __construct(PostMedia $model)
    {
        parent::__construct($model);
    }
}
