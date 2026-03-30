<?php

declare(strict_types=1);

namespace Database\Seeders\Calls\Local;

use App\Models\Auth\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPassword = Hash::make(env('DEFAULT_PASSWORD', 'password'));

        // Static users with known identities — useful for targeted testing.
        DB::statement(csvToSql(User::class, database_path('seeders/data/Local/users.csv')));
        DB::table(User::make()->getTable())
            ->whereNull('password')
            ->update(['password' => $defaultPassword]);

        // Random users for pagination/search testing.
        User::factory(10)
            ->create(['password' => $defaultPassword]);
    }
}
