<?php

namespace App\Services\Common;

use App\Enums\LogType;
use Illuminate\Support\Facades\Log;

class LogService
{
    /**
     * Log an error message.
     *
     * @param string $title The title of the log
     * @param array<mixed> $context The body of the log
     * @param string|null $channel The channel name of the log
     *
     * @return void
     */
    public static function error(
        string $title,
        array $context = [],
        ?string $channel = null,
    ) {
        self::write(LogType::ERROR, $title, $context, $channel);
    }

    /**
     * Log an info message.
     *
     * @param string $title The title of the log
     * @param array<mixed> $context The body of the log
     * @param string|null $channel The channel name of the log
     *
     * @return void
     */
    public static function info(
        string $title,
        array $context = [],
        ?string $channel = null,
    ) {
        self::write(LogType::ERROR, $title, $context, $channel);
    }

    /**
     * Log a debug message.
     *
     * @param string $title The title of the log
     * @param array<mixed> $context The body of the log
     * @param string|null $channel The channel name of the log
     *
     * @return void
     */
    public static function debug(
        string $title,
        array $context = [],
        ?string $channel = null,
    ) {
        self::write(LogType::ERROR, $title, $context, $channel);
    }

    /**
     * Log a notice message.
     *
     * @param string $title The title of the log
     * @param array<mixed> $context The body of the log
     * @param string|null $channel The channel name of the log
     *
     * @return void
     */
    public static function notice(
        string $title,
        array $context = [],
        ?string $channel = null,
    ) {
        self::write(LogType::ERROR, $title, $context, $channel);
    }

    /**
     * Creates a log.
     *
     * @param string $logType (error, info, debug, notice)
     * @param string $title The title of the log
     * @param array<string, mixed> $context The body of the log
     * @param string|null $channel The channel name of the log
     *
     * @return void
     */
    private static function write(
        string $logType,
        string $title,
        array $context,
        ?string $channel,
    ): void {
        $logger = $channel
            ? Log::channel($channel)
            : Log::getFacadeRoot();

        // Sample: $logger->info('This is a dynamic info log.');
        $logger->{$logType}($title, $context);
    }
}
