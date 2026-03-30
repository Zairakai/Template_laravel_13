<?php

declare(strict_types=1);

use App\Models\Auth\PasswordResetToken;
use App\Models\Auth\Session;
use App\Models\Auth\User;
use App\Models\Queue\FailedJob;
use App\Models\Queue\Job;
use App\Models\Queue\JobBatch;

describe('table name resolution', function (): void {
    it('derives auth_users from Auth\\User namespace', function (): void {
        expect(User::getTableName())->toBe('auth_users');
    });

    it('derives auth_sessions from Auth\\Session namespace', function (): void {
        expect(Session::getTableName())->toBe('auth_sessions');
    });

    it('derives auth_password_reset_tokens from Auth\\PasswordResetToken namespace', function (): void {
        expect(PasswordResetToken::getTableName())->toBe('auth_password_reset_tokens');
    });

    it('derives queue_jobs from Queue\\Job namespace', function (): void {
        expect(Job::getTableName())->toBe('queue_jobs');
    });

    it('derives queue_job_batches from Queue\\JobBatch namespace', function (): void {
        expect(JobBatch::getTableName())->toBe('queue_job_batches');
    });

    it('derives queue_failed_jobs from Queue\\FailedJob namespace', function (): void {
        expect(FailedJob::getTableName())->toBe('queue_failed_jobs');
    });
});

describe('column resolution', function (): void {
    it('resolves User camelCase keys to snake_case columns', function (): void {
        expect(User::resolveColumn('rememberToken'))->toBe('remember_token')
            ->and(User::resolveColumn('emailVerifiedAt'))->toBe('email_verified_at')
            ->and(User::resolveColumn('createdAt'))->toBe('created_at');
    });

    it('resolves Session userId to user_id', function (): void {
        expect(Session::resolveColumn('userId'))->toBe('user_id')
            ->and(Session::resolveColumn('ipAddress'))->toBe('ip_address')
            ->and(Session::resolveColumn('lastActivity'))->toBe('last_activity');
    });

    it('falls back to the key itself when not in COLUMNS', function (): void {
        expect(User::resolveColumn('unknown_key'))->toBe('unknown_key');
    });
});

describe('primary key resolution', function (): void {
    it('defaults to id for User', function (): void {
        expect(User::getPrimaryKeyName())->toBe('id');
    });

    it('uses email as primary key for PasswordResetToken', function (): void {
        expect(PasswordResetToken::getPrimaryKeyName())->toBe('email');
    });
});
