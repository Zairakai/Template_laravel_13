<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            User::resolveColumn('name')             => fake()->name(),
            User::resolveColumn('email')            => fake()->unique()->safeEmail(),
            User::resolveColumn('emailVerifiedAt')  => now(),
            User::resolveColumn('password')         => (static::$password ??= Hash::make('password')),
            User::resolveColumn('rememberToken')    => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(
            fn () => [
                User::resolveColumn('emailVerifiedAt') => null,
            ],
        );
    }
}
