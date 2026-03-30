<?php

declare(strict_types=1);

use App\Models\Auth\PasswordResetToken;
use App\Models\Auth\Session;
use App\Models\Auth\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Session::getTableName());
        Schema::dropIfExists(PasswordResetToken::getTableName());
        Schema::dropIfExists(User::getTableName());
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(User::getTableName(), function (Blueprint $table) {
            $table->id(User::resolveColumn('id'));
            $table->string(User::resolveColumn('name'));
            $table->string(User::resolveColumn('email'))->unique();
            $table->timestamp(User::resolveColumn('emailVerifiedAt'))->nullable();
            $table->string(User::resolveColumn('password'));
            $table->string(User::resolveColumn('rememberToken'), 100)->nullable();
            $table->timestamp(User::resolveColumn('createdAt'))->nullable();
            $table->timestamp(User::resolveColumn('updatedAt'))->nullable();
        });

        Schema::create(PasswordResetToken::getTableName(), function (Blueprint $table) {
            $table->string(PasswordResetToken::resolveColumn('email'))->primary();
            $table->string(PasswordResetToken::resolveColumn('token'));
            $table->timestamp(PasswordResetToken::resolveColumn('createdAt'))->nullable();
        });

        Schema::create(Session::getTableName(), function (Blueprint $table) {
            $table->string(Session::resolveColumn('id'))->primary();
            $table->foreignId(Session::resolveColumn('userId'))->nullable()->index();
            $table->string(Session::resolveColumn('ipAddress'), 45)->nullable();
            $table->text(Session::resolveColumn('userAgent'))->nullable();
            $table->longText(Session::resolveColumn('payload'));
            $table->integer(Session::resolveColumn('lastActivity'))->index();
        });
    }
};
