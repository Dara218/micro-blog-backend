<?php

namespace App\Enums;

/**
 * Enums for likeable type.
 */
enum LikeableType: string
{
    /**
     * Post likeable type.
     */
    case POST = 'post';

    /**
     * Comment likeable type.
     */
    case COMMENT = 'comment';
}
