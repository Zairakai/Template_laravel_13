<?php

declare(strict_types=1);

namespace App\Models\Auth;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordResetToken extends BaseModel
{
    /**
     * @var array<string, string>
     */
    public const array COLUMNS = [
        'email'     => 'email',
        'token'     => 'token',
        'createdAt' => 'created_at',
    ];

    public const string PRIMARY_KEY = 'email';

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            static::resolveColumn('email'),
            User::resolveColumn('email'),
        );
    }
}
