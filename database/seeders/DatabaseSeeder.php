<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seeders run on all non-production environments.
     *
     * @var array<int, string>
     */
    protected array $commonSeeders = [
        'Calls/Common',
    ];

    /**
     * Environment-specific seeder directories.
     *
     * @var array<string, array<int, string>>
     */
    protected array $environmentSeeders = [
        'local' => ['Calls/Local'],
        'testing' => ['Calls/Testing'],
        'staging' => ['Calls/Staging'],
    ];

    /**
     * Prepare the environment for seeding:
     * disable mass-assignment protection, foreign key constraints and activity logging.
     */
    public function __construct()
    {
        Model::unguard();
        Schema::disableForeignKeyConstraints();
        activity()->disableLogging();
    }

    /**
     * Restore the environment after seeding.
     */
    public function __destruct()
    {
        activity()->enableLogging();
        Schema::enableForeignKeyConstraints();
        Model::reguard();
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (App::isProduction()) {
            return;
        }

        foreach ($this->commonSeeders as $directory) {
            $this->loadSeedersFromPath(database_path('seeders/'.$directory));
        }

        $environment = App::environment();

        if (isset($this->environmentSeeders[$environment])) {
            foreach ($this->environmentSeeders[$environment] as $directory) {
                $this->loadSeedersFromPath(database_path('seeders/'.$directory));
            }
        }
    }

    /**
     * Auto-discover and call all seeder classes found in the given directory.
     */
    protected function loadSeedersFromPath(string $path): void
    {
        if (! File::isDirectory($path)) {
            return;
        }

        $seeders = collect(File::files($path))
            ->filter(fn ($file) => $file->getExtension() === 'php')
            ->map(fn ($file) => str_replace(
                [database_path('seeders/'), '.php', '/'],
                ['Database\\Seeders\\', '', '\\'],
                $file->getRealPath(),
            ))
            ->filter(fn ($class) => class_exists($class))
            ->values()
            ->all();

        if ($seeders !== []) {
            $this->call($seeders);
        }
    }
}
