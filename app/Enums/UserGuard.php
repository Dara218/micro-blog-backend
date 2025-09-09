<?php

namespace App\Enums;

/**
 * Enums for user guards.
 */
enum UserGuard: string
{
    /**
     * User guard.
     */
    case USER = 'user';

    /**
     * Admin guard;
     */
    case ADMIN = 'admin';
}
