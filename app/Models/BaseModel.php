<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Zairakai\LaravelActivity\Traits\TraceActivities;
use Zairakai\LaravelEloquent\Traits\BaseTable;

/**
 * Base model for all application models.
 *
 * Concrete models MUST define the following constants to satisfy BaseTable:
 *
 * ```php
 * // Required — logical name → actual column name mapping.
 * // Used for column resolution, fill(), getAttribute(), isFillable(), etc.
 * const COLUMNS = [
 *     'id'   => 'user_id',
 *     'name' => 'user_name',
 * ];
 *
 * // Optional — override the auto-derived table name (snake_plural of class name).
 * const TABLE_NAME = 'users';
 *
 * // Optional — override the primary key (defaults to COLUMNS['id'] or 'id').
 * const PRIMARY_KEY = 'user_id';
 *
 * // Optional — deprecated column → new column name.
 * // Logs a warning and transparently redirects to the new column.
 * const COLUMNS_DELETED = [
 *     'old_name' => 'new_name',
 * ];
 * ```
 *
 * @see BaseTable
 */
abstract class BaseModel extends Model
{
    use BaseTable;
    use TraceActivities;
}
