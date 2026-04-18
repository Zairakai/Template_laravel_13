<?php

declare(strict_types=1);

use App\Models\Activity\Log;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function down(): void
    {
        $this->schema()->dropIfExists(Log::getTableName());
    }

    public function up(): void
    {
        $this->schema()->create(Log::getTableName(), function (Blueprint $table) {
            $table->bigIncrements(Log::resolveColumn('id'));
            $table->string(Log::resolveColumn('logName'))->nullable();
            $table->text(Log::resolveColumn('description'));
            $table->string(Log::resolveColumn('subjectType'))->nullable();
            $table->unsignedBigInteger(Log::resolveColumn('subjectId'))->nullable();
            $table->index([Log::resolveColumn('subjectType'), Log::resolveColumn('subjectId')], 'subject');
            $table->string(Log::resolveColumn('causerType'))->nullable();
            $table->unsignedBigInteger(Log::resolveColumn('causerId'))->nullable();
            $table->index([Log::resolveColumn('causerType'), Log::resolveColumn('causerId')], 'causer');
            $table->json(Log::resolveColumn('properties'))->nullable();
            $table->timestamp(Log::resolveColumn('createdAt'))->nullable();
            $table->timestamp(Log::resolveColumn('updatedAt'))->nullable();
            $table->index(Log::resolveColumn('logName'));
        });
    }

    private function schema(): Builder
    {
        /** @var string $connection */
        $connection = config('activitylog.database_connection') ?? config('database.default');

        return Schema::connection($connection);
    }
};
