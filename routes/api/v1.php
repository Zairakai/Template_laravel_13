<?php

declare(strict_types=1);

use App\Http\Controllers\API\V1\Cache\TransController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API v1 Routes
|--------------------------------------------------------------------------
|
| All routes here are prefixed with /api/v1 automatically.
|
*/

Route::get('/health', static fn () => response()->json([
    'status'  => 'ok',
    'version' => 'v1',
]));

// Public intentionally — translations are UI strings only, not sensitive data.
// lang/ files must not contain role-specific or business-logic translations.
// If a project needs role-aware translations, add a dedicated authenticated
// endpoint in that project (e.g. GET /api/v1/user/context).
Route::prefix('/cache')->group(function (): void {
    Route::get('/trans/{lang}', TransController::class);
});
