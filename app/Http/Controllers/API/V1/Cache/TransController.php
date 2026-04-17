<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\V1\Cache;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

use function basename;
use function glob;
use function in_array;
use function is_array;
use function is_string;
use function str_replace;

class TransController extends Controller
{
    private readonly int $cacheDuration;

    public function __construct()
    {
        $this->cacheDuration = in_array(config('app.env'), ['production', 'staging'], true)
            ? 300
            : 0;
    }

    public function __invoke(string $lang): JsonResponse
    {
        $strings = Cache::remember(
            "lang-{$lang}",
            $this->cacheDuration,
            function () use ($lang): array {
                $globResult = glob(base_path("lang/{$lang}/*.php"));

                /** @var array<int, string> $files */
                $files = $globResult !== false ? $globResult : [];

                /** @var string $appName */
                $appName = config('app.name');

                $strings = [];

                foreach ($files as $file) {
                    $name = basename($file, '.php');

                    /** @var array<string, mixed> $translations */
                    $translations = require $file;
                    $strings[$name] = $this->replaceAppName($appName, $translations);
                }

                return $strings;
            },
        );

        return response()->json($strings);
    }

    /**
     * Recursively replace :app_name placeholder with the actual app name.
     *
     * @param  array<string, mixed>  $array
     * @return array<string, mixed>
     */
    private function replaceAppName(string $appName, array $array): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                /** @var array<string, mixed> $nested */
                $nested = $value;
                $array[$key] = $this->replaceAppName($appName, $nested);
            } elseif (is_string($value)) {
                $array[$key] = str_replace(':app_name', $appName, $value);
            }
        }

        return $array;
    }
}
