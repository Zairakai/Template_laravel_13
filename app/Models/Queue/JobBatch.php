<?php

declare(strict_types=1);

namespace App\Models\Queue;

use App\Models\BaseModel;

class JobBatch extends BaseModel
{
    /**
     * @var array<string, string>
     */
    public const array COLUMNS = [
        'id'           => 'id',
        'name'         => 'name',
        'totalJobs'    => 'total_jobs',
        'pendingJobs'  => 'pending_jobs',
        'failedJobs'   => 'failed_jobs',
        'failedJobIds' => 'failed_job_ids',
        'options'      => 'options',
        'cancelledAt'  => 'cancelled_at',
        'createdAt'    => 'created_at',
        'finishedAt'   => 'finished_at',
    ];

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';
}
