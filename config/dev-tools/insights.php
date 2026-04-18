<?php

declare(strict_types=1);

use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenPrivateMethods;
use PhpCsFixer\Fixer\ClassNotation\ClassDefinitionFixer;
use SlevomatCodingStandard\Sniffs\Classes\ForbiddenPublicPropertySniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ReturnTypeHintSniff;

/**
 * PHP Insights Configuration
 * --------------------------.
 *
 * Extends the base configuration from laravel-dev-tools.
 *
 * IMPORTANT: For arrays with numeric keys (remove, add, exclude),
 * use the spread operator [...] to merge. Do NOT use array_replace_recursive()
 * as it replaces by index instead of merging.
 */
$baseConfig    = [];
$currentFile   = __FILE__;
$possiblePaths = [
    /* Normal Laravel project */
    dirname(__DIR__, 2) . '/vendor/zairakai/laravel-dev-tools/config/insights.base.php',

    /* Testbench environment */
    dirname(__DIR__, 6) . '/config/insights.base.php',

    /* Local project config */
    dirname(__DIR__, 2) . '/config/insights.base.php',
];

foreach ($possiblePaths as $path) {
    if (file_exists($path) && realpath($path) !== realpath($currentFile)) {
        $baseConfig = require $path;

        break;
    }
}

/* Laravel app exclusions */
$baseConfig['exclude'] = array_unique([
    ...($baseConfig['exclude'] ?? []),
    'bootstrap/cache',
    'build',
    'storage',
    'public',
    // autoload-dev only — intentionally global, not available in production
    'app/Support/Helpers-dev.php',
]);

$baseConfig['remove'] = [
    ...($baseConfig['remove'] ?? []),
    // Conflicts with Pint single_line_empty_body rule
    ClassDefinitionFixer::class,
    // Eloquent requires public $timestamps, $incrementing, $keyType — not a smell in Laravel
    ForbiddenPublicPropertySniff::class,
    // Does not understand Eloquent generic relations (HasMany<Model, $this>) — false positives
    ReturnTypeHintSniff::class,
];

$baseConfig['threads'] = 1;

$baseConfig['config'][ForbiddenPrivateMethods::class] = [
    'title' => 'The usage of private methods is not idiomatic in Laravel.',
];

return $baseConfig;
