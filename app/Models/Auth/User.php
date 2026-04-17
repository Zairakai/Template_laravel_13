<?php

declare(strict_types=1);

namespace App\Models\Auth;

use App\Models\BaseAuthenticatable;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class User extends BaseAuthenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use Notifiable;

    /**
     * @var array<string, string>
     */
    public const array COLUMNS = [
        'id' => 'id',
        'name' => 'name',
        'email' => 'email',
        'password' => 'password',
        'rememberToken' => 'remember_token',
        'emailVerifiedAt' => 'email_verified_at',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];

    /**
     * @return list<string>
     */
    public function getHidden(): array
    {
        return [
            static::resolveColumn('password'),
            static::resolveColumn('rememberToken'),
        ];
    }

    /**
     * @return HasOne<PasswordResetToken, $this>
     */
    public function passwordResetToken(): HasOne
    {
        return $this->hasOne(
            PasswordResetToken::class,
            PasswordResetToken::resolveColumn('email'),
            static::resolveColumn('email'),
        );
    }

    /**
     * @return HasMany<Session, $this>
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class, Session::resolveColumn('userId'));
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            static::resolveColumn('emailVerifiedAt') => 'datetime',
            static::resolveColumn('password') => 'hashed',
        ];
    }
}
