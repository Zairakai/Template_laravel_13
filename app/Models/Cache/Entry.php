<?php

declare(strict_types=1);

namespace App\Models\Cache;

use App\Models\BaseModel;

class Entry extends BaseModel
{
    /**
     * @var array<string, string>
     */
    public const array COLUMNS = [
        'key'        => 'key',
        'value'      => 'value',
        'expiration' => 'expiration',
    ];

    public const string PRIMARY_KEY = 'key';

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';
}
