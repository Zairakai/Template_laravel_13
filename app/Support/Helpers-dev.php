<?php

declare(strict_types=1);

// Development-only helper functions (seeding, debugging, etc.).
// Loaded via autoload-dev — never available in production.

use Illuminate\Database\Eloquent\Model;

if (! function_exists('csvToSql')) {
    /**
     * Convert a CSV file to a raw SQL INSERT statement for high-performance seeding.
     *
     * Usage:
     *   DB::statement(csvToSql(User::class, database_path('seeders/data/users.csv')));
     *   DB::statement(csvToSql('users', database_path('seeders/data/users.csv')));
     *
     * CSV requirements:
     *   - First row = column headers (matching DB column names, or mapped via $columnMap)
     *   - Use the string "NULL" for SQL NULL values
     *   - JSON values are automatically detected (strings starting with '{' or '[')
     *
     * @param  class-string<Model>|string  $tableOrModel  Eloquent model class or raw table name
     * @param  string  $csvPath  Absolute path to the CSV file
     * @param  array<string, string>  $columnMap  Optional CSV header → DB column rename map
     *
     * @throws RuntimeException if the CSV file cannot be opened or is empty
     */
    function csvToSql(
        string $tableOrModel,
        string $csvPath,
        array $columnMap = [],
    ): string {
        $table = is_subclass_of($tableOrModel, Model::class)
            ? (new $tableOrModel)->getTable()
            : $tableOrModel;

        $handle = fopen($csvPath, 'r');

        if ($handle === false) {
            throw new RuntimeException(sprintf('csvToSql: cannot open CSV file "%s"', $csvPath));
        }

        $headers = fgetcsv($handle);

        if ($headers === false) {
            fclose($handle);

            throw new RuntimeException(sprintf('csvToSql: CSV file "%s" is empty or has no headers', $csvPath));
        }

        // Cast headers to strings — fgetcsv may return null for empty CSV fields
        $headers = array_map(strval(...), $headers);

        $columns = array_map(
            static fn (string $col): string => '`'.($columnMap[$col] ?? $col).'`',
            $headers,
        );

        $rows = [];

        while (false !== ($line = fgetcsv($handle))) {
            /** @var array<string, string> $row */
            $row = array_combine($headers, $line);

            $escaped = array_map(
                static function (string $value): string {
                    if ($value === 'NULL') {
                        return 'NULL';
                    }

                    if (str_starts_with($value, '{') || str_starts_with($value, '[')) {
                        return "'".addslashes($value)."'";
                    }

                    return '"'.addslashes($value).'"';
                },
                array_values($row),
            );

            $rows[] = '('.implode(',', $escaped).')';
        }

        fclose($handle);

        if ($rows === []) {
            throw new RuntimeException(sprintf('csvToSql: CSV file "%s" contains headers but no data rows', $csvPath));
        }

        return sprintf(
            'INSERT INTO `%s` (%s) VALUES %s',
            $table,
            implode(',', $columns),
            implode(',', $rows),
        );
    }
}
