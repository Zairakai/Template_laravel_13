<?php

declare(strict_types=1);

namespace Database\Seeders\Calls\Common;

use App\Models\Auth\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPassword = Hash::make(env('DEFAULT_PASSWORD', 'password'));

        DB::statement(csvToSql(User::class, database_path('seeders/data/Common/users.csv')));

        // Override the admin email if set in .env.
        DB::table(User::make()->getTable())
            ->where('email', 'admin@example.com')
            ->update([
                'email'    => env('ADMIN_EMAIL', 'admin@example.com'),
                'password' => $defaultPassword,
            ]);
    }
}
