<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zairakai\LaravelActivity\Traits\TraceActivities;
use Zairakai\LaravelEloquent\Traits\BaseTable;

/**
 * Base model for all authenticatable models (users, admins, ...).
 *
 * Mirrors BaseModel but extends Authenticatable instead of Model.
 *
 * Concrete models MUST define the following constants to satisfy BaseTable:
 *
 * ```php
 * // Required — logical name → actual column name mapping.
 * const COLUMNS = [
 *     'id'    => 'user_id',
 *     'email' => 'user_email',
 * ];
 *
 * // Optional — override the auto-derived table name.
 * const TABLE_NAME = 'users';
 *
 * // Optional — override the primary key (defaults to COLUMNS['id'] or 'id').
 * const PRIMARY_KEY = 'user_id';
 *
 * // Optional — deprecated column → new column name (logs warning + redirects).
 * const COLUMNS_DELETED = [
 *     'old_name' => 'new_name',
 * ];
 * ```
 *
 * @see BaseTable
 */
abstract class BaseAuthenticatable extends Authenticatable
{
    use BaseTable;
    use TraceActivities;
}
