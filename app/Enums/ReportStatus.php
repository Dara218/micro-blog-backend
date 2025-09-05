<?php

namespace App\Enums;

/**
 * Enums for reports.status.
 */
enum ReportStatus: string
{
    /**
     * OPEN status.
     */
    case OPEN = 'OPEN';

    /**
     * REVIEWING status.
     */
    case REVIEWING = 'REVIEWING';

    /**
     * RESOLVED status.
     */
    case RESOLVED = 'RESOLVED';

    /**
     * DISMISSED status.
     */
    case DISMISSED = 'DISMISSED';

    /**
     * Get the list of all enum values.
     *
     * @return array<mixed, string>
     */
    public static function list()
    {
        return array_map(fn(self $enum) => $enum->value, ReportStatus::cases());
    }
}
