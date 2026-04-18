<?php

declare(strict_types=1);

use App\Models\Cache\Entry;
use App\Models\Cache\Lock;
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
        Schema::dropIfExists(Lock::getTableName());
        Schema::dropIfExists(Entry::getTableName());
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Entry::getTableName(), function (Blueprint $table) {
            $table->string(Entry::resolveColumn('key'))->primary();
            $table->mediumText(Entry::resolveColumn('value'));
            $table->integer(Entry::resolveColumn('expiration'));
        });

        Schema::create(Lock::getTableName(), function (Blueprint $table) {
            $table->string(Lock::resolveColumn('key'))->primary();
            $table->string(Lock::resolveColumn('owner'));
            $table->integer(Lock::resolveColumn('expiration'));
        });
    }
};
