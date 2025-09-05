<?php

namespace App\Enums;

/**
 * Enums for posts.is_comments_allowed.
 */
enum CommentsAllowFlag: int
{
    /**
     * Comments not allowed.
     */
    case NOT_ALLOWED = 0;

    /**
     * Comments allowed.
     */
    case ALLOW = 1;
}
