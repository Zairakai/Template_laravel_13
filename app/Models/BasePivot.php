<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Zairakai\LaravelEloquent\Traits\BaseTable;

/**
 * Base pivot model for all application pivot models.
 *
 * Concrete pivot models MUST define the following constants to satisfy BaseTable:
 *
 * ```php
 * // Required — logical name → actual column name mapping.
 * const COLUMNS = [
 *     'userId'    => 'user_id',
 *     'roleId'    => 'role_id',
 *     'createdAt' => 'created_at',
 *     'updatedAt' => 'updated_at',
 * ];
 *
 * // Optional — override the auto-derived table name.
 * const TABLE_NAME = 'role_user';
 * ```
 *
 * @see BaseTable
 */
abstract class BasePivot extends Pivot
{
    use BaseTable;
}
