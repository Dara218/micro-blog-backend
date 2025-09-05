<?php

namespace App\Enums;

/**
 * Enums for follows.status.
 */
enum FollowStatus: string
{
    /**
     * Accepted follow status.
     */
    case ACCEPTED = 'ACCEPTED';

    /**
     * Pending follow status.
     */
    case PENDING = 'PENDING';

    /**
     * Blocked follow status.
     */
    case BLOCKED = 'BLOCKED';

    /**
     * Get the list of all enum values.
     *
     * @return array<mixed, string>
     */
    public static function list()
    {
        return array_map(fn(self $enum) => $enum->value, FollowStatus::cases());
    }
}
