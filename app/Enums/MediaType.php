<?php

namespace App\Enums;

/**
 * Enums for post_medias.type.
 */
enum MediaType: string
{
    /**
     * IMAGE media type.
     */
    case IMAGE = 'IMAGE';

    /**
     * VIDEO media type.
     */
    case VIDEO = 'VIDEO';

    /**
     * Get the list of all enum values.
     *
     * @return array<mixed, string>
     */
    public static function list(): array
    {
        return array_map(fn(self $enum) => $enum->value, MediaType::cases());
    }
}
