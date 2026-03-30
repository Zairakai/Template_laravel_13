<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Raise exceptions for lazy loading, missing attributes and silently discarded fills — dev only.
        Model::shouldBeStrict(! $this->app->environment('production'));

        // Prevent accidental destructive commands (migrate:fresh, db:wipe, ...) in production.
        DB::prohibitDestructiveCommands($this->app->environment('production'));

        $this->configureRateLimiting();
    }

    public function register(): void {}

    private function configureRateLimiting(): void
    {
        /** @var int $maxAttempts */
        $maxAttempts = config('api.throttle.max_attempts', 60);

        /** @var int $decayMinutes */
        $decayMinutes = config('api.throttle.decay_minutes', 1);

        RateLimiter::for('api', static fn (Request $request): Limit => Limit::perMinutes($decayMinutes, $maxAttempts)
            ->by($request->user()?->getKey() ?? $request->ip()));
    }
}
