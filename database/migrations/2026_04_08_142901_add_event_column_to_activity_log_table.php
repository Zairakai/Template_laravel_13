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
        $this->schema()->table(Log::getTableName(), function (Blueprint $table) {
            $table->dropColumn(Log::resolveColumn('event'));
        });
    }

    public function up(): void
    {
        $this->schema()->table(Log::getTableName(), function (Blueprint $table) {
            $table->string(Log::resolveColumn('event'))->nullable()->after(Log::resolveColumn('subjectType'));
        });
    }

    private function schema(): Builder
    {
        /** @var string $connection */
        $connection = config('activitylog.database_connection') ?? config('database.default');

        return Schema::connection($connection);
    }
};
