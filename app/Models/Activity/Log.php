<?php

declare(strict_types=1);

namespace App\Models\Activity;

use Spatie\Activitylog\Models\Activity;
use Zairakai\LaravelEloquent\Traits\BaseTable;

/**
 * Custom Activity model.
 *
 * Extends Spatie's Activity to enforce project-wide column resolution
 * and namespace-derived table naming (activity_logs).
 *
 * BaseTable::initializeTable() runs after Spatie's __construct() table
 * assignment, so the auto-derived name always takes precedence.
 *
 * TraceActivities is intentionally excluded to prevent recursive logging.
 */
class Log extends Activity
{
    use BaseTable;

    /**
     * @var array<string, string>
     */
    public const array COLUMNS = [
        'id'          => 'id',
        'logName'     => 'log_name',
        'description' => 'description',
        'subjectType' => 'subject_type',
        'subjectId'   => 'subject_id',
        'causerType'  => 'causer_type',
        'causerId'    => 'causer_id',
        'properties'  => 'properties',
        'event'       => 'event',
        'batchUuid'   => 'batch_uuid',
        'createdAt'   => 'created_at',
        'updatedAt'   => 'updated_at',
    ];
}
