<?php

declare(strict_types=1);

return [
    /*
    | Column Resolution Logging
    |
    | Configure logging behavior for column resolution. This helps track
    | deprecated column usage and missing column mappings during development.
    |
    */

    'logging' => [
        /*
        | Enable Logging
        |
        | When enabled, the package will log warnings for deprecated columns
        | (COLUMNS_DELETED) and info messages for missing columns (fallback).
        |
        | Set to false in production to disable all column resolution logging.
        |
        */
        'enabled' => env('ELOQUENT_LOGGING_ENABLED', true),

        /*
        | Log Channel
        |
        | The log channel to use for column resolution messages.
        | Must be a valid channel defined in config/logging.php.
        |
        | Leave empty to use the default Laravel log channel.
        |
        */
        'channel' => env('ELOQUENT_LOGGING_CHANNEL'),

        /*
        | Log Levels
        |
        | Configure log levels for different types of column resolution events.
        |
        | Available levels: 'emergency', 'alert', 'critical', 'error',
        |                   'warning', 'notice', 'info', 'debug'
        |
        */
        'levels' => [
            'deprecated' => env('ELOQUENT_LOG_LEVEL_DEPRECATED', 'warning'),
            'missing'    => env('ELOQUENT_LOG_LEVEL_MISSING', 'info'),
        ],

        /*
        | Include Backtrace
        |
        | When enabled, log entries will include a backtrace showing where
        | the column resolution was called from. Helpful for debugging but
        | increases log size.
        |
        */
        'include_backtrace' => env('ELOQUENT_LOGGING_BACKTRACE', true),

        /*
        | Backtrace Depth
        |
        | Number of stack frames to include in the backtrace (when enabled).
        |
        */
        'backtrace_depth' => env('ELOQUENT_LOGGING_BACKTRACE_DEPTH', 5),

        /*
        | Excluded Models
        |
        | List of fully qualified model class names that should NOT log
        | column resolution messages.
        |
        */
        'excluded_models' => [],
    ],

    /*
    | Request-scoped Query Cache
    |
    | When enabled, identical SELECT queries are cached for the duration of the
    | current request using the array cache store. Duplicate queries hit the
    | cache instead of the DB.
    |
    | Works correctly in both PHP-FPM and Laravel Octane.
    |
    */

    'request_cache' => [
        'enabled' => env('ELOQUENT_REQUEST_CACHE', false),
    ],
];
