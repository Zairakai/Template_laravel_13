<?php

declare(strict_types=1);

namespace App\Models\Queue;

use App\Models\BaseModel;

class FailedJob extends BaseModel
{
    /**
     * @var array<string, string>
     */
    public const array COLUMNS = [
        'id' => 'id',
        'uuid' => 'uuid',
        'connection' => 'connection',
        'queue' => 'queue',
        'payload' => 'payload',
        'exception' => 'exception',
        'failedAt' => 'failed_at',
    ];

    public $timestamps = false;
}
