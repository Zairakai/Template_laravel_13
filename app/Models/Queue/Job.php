<?php

declare(strict_types=1);

namespace App\Models\Queue;

use App\Models\BaseModel;

class Job extends BaseModel
{
    /**
     * @var array<string, string>
     */
    public const array COLUMNS = [
        'id'          => 'id',
        'queue'       => 'queue',
        'payload'     => 'payload',
        'attempts'    => 'attempts',
        'reservedAt'  => 'reserved_at',
        'availableAt' => 'available_at',
        'createdAt'   => 'created_at',
    ];

    public $timestamps = false;
}
