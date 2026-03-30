<?php

declare(strict_types=1);

use App\Models\Queue\FailedJob;
use App\Models\Queue\Job;
use App\Models\Queue\JobBatch;
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
        Schema::dropIfExists(FailedJob::getTableName());
        Schema::dropIfExists(JobBatch::getTableName());
        Schema::dropIfExists(Job::getTableName());
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Job::getTableName(), function (Blueprint $table) {
            $table->id(Job::resolveColumn('id'));
            $table->string(Job::resolveColumn('queue'))->index();
            $table->longText(Job::resolveColumn('payload'));
            $table->unsignedTinyInteger(Job::resolveColumn('attempts'));
            $table->unsignedInteger(Job::resolveColumn('reservedAt'))->nullable();
            $table->unsignedInteger(Job::resolveColumn('availableAt'));
            $table->unsignedInteger(Job::resolveColumn('createdAt'));
        });

        Schema::create(JobBatch::getTableName(), function (Blueprint $table) {
            $table->string(JobBatch::resolveColumn('id'))->primary();
            $table->string(JobBatch::resolveColumn('name'));
            $table->integer(JobBatch::resolveColumn('totalJobs'));
            $table->integer(JobBatch::resolveColumn('pendingJobs'));
            $table->integer(JobBatch::resolveColumn('failedJobs'));
            $table->longText(JobBatch::resolveColumn('failedJobIds'));
            $table->mediumText(JobBatch::resolveColumn('options'))->nullable();
            $table->integer(JobBatch::resolveColumn('cancelledAt'))->nullable();
            $table->integer(JobBatch::resolveColumn('createdAt'));
            $table->integer(JobBatch::resolveColumn('finishedAt'))->nullable();
        });

        Schema::create(FailedJob::getTableName(), function (Blueprint $table) {
            $table->id(FailedJob::resolveColumn('id'));
            $table->string(FailedJob::resolveColumn('uuid'))->unique();
            $table->text(FailedJob::resolveColumn('connection'));
            $table->text(FailedJob::resolveColumn('queue'));
            $table->longText(FailedJob::resolveColumn('payload'));
            $table->longText(FailedJob::resolveColumn('exception'));
            $table->timestamp(FailedJob::resolveColumn('failedAt'))->useCurrent();
        });
    }
};
