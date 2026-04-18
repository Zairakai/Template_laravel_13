<?php

declare(strict_types=1);

return [
    /*
    | Password component
    |
    | Minimum number of characters required for the password field.
    |
    */
    'password' => [
        'min_characters' => env('BLADE_PASSWORD_MIN_CHARACTERS', 8),
    ],

    /*
    | Email component
    |
    | Regex pattern applied to the email input for browser-side validation.
    | Override to use a stricter pattern if needed.
    |
    */
    'email' => [
        'pattern' => '[^@]+@[^@]+\.[a-zA-Z]{2,}',
    ],

    /*
    | Select component
    |
    | Default icon displayed after the select element (Material Symbols name).
    | Set to null to disable the icon.
    |
    */
    'select' => [
        'icon_after' => env('BLADE_SELECT_ICON_AFTER', 'keyboard_arrow_down'),
    ],
];
