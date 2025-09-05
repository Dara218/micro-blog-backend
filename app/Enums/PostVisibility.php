<?php

namespace App\Enums;

/**
 * Enums for posts.visibility.
 */
enum PostVisibility: string
{
    /**
     * PUBLIC visibility.
     */
    case PUBLIC = 'PUBLIC';

    /**
     * FOLLOWERS visibility.
     */
    case FOLLOWERS = 'FOLLOWERS';

    /**
     * PRIVATE visibility.
     */
    case PRIVATE = 'PRIVATE';

    /**
     * Get the list of all enum values.
     *
     * @return array<mixed, string>
     */
    public static function list(): array
    {
        return array_map(fn(self $enum) => $enum->value, PostVisibility::cases());
    }
}
