<?php

namespace App\Enums;

/**
 * Enumeration for Logging Type
 */
enum LogType: string
{
    /**
     * ERROR
     */
    public const ERROR = 'error';

    /**
     * INFO
     */
    public const INFO = 'info';

    /**
     * DEBUG
     */
    public const DEBUG = 'debug';

    /**
     * NOTICE
     */
    public const NOTICE = 'notice';
}
