<?php

namespace App\Enums;

/**
 * Enums for posts.is_shares_allowed.
 */
enum SharesAllowFlag: int
{
    /**
     * Shares not allowed.
     */
    case NOT_ALLOWED = 0;

    /**
     * Shares allowed.
     */
    case ALLOW = 1;
}
