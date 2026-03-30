<?php

declare(strict_types=1);

namespace App\Models\Auth;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Session extends BaseModel
{
    /**
     * @var array<string, string>
     */
    public const array COLUMNS = [
        'id'           => 'id',
        'userId'       => 'user_id',
        'ipAddress'    => 'ip_address',
        'userAgent'    => 'user_agent',
        'payload'      => 'payload',
        'lastActivity' => 'last_activity',
    ];

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, static::resolveColumn('userId'));
    }
}
