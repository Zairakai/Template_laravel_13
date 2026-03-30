<?php

declare(strict_types=1);

use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;

it('returns JSON 404 for unknown API route', function (): void {
    /** @var TestResponse<Response> $response */
    $response = $this->getJson('/api/v1/nonexistent');

    $this->assertApiError($response, 404);
});

it('returns HTML 404 for unknown web route', function (): void {
    /** @var TestResponse<Response> $response */
    $response = $this->get('/nonexistent');

    $response->assertStatus(404);
    $response->assertHeader('Content-Type', 'text/html; charset=utf-8');
});
