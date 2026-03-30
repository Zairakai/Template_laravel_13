<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | API Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Controls the named "api" rate limiter used by the throttle:api middleware.
    | max_attempts : number of requests allowed per window
    | decay_minutes: length of the rolling window in minutes
    |
    */

    'throttle' => [
        'max_attempts'  => (int) env('API_THROTTLE_MAX_ATTEMPTS', 60),
        'decay_minutes' => (int) env('API_THROTTLE_DECAY_MINUTES', 1),
    ],

];
