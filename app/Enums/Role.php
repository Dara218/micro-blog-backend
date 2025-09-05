<?php

namespace App\Enums;

/**
 * Enums for conversation_participants.role.
 */
enum Role: string
{
    /**
     * MEMBER role.
     */
    case MEMBER = 'MEMBER';

    /**
     * ADMIN role.
     */
    case ADMIN = 'ADMIN';

    /**
     * Get the list of all enum values.
     *
     * @return array<mixed, string>
     */
    public static function list(): array
    {
        return array_map(fn(self $enum) => $enum->value, Role::cases());
    }
}
