<?php

declare(strict_types=1);

use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;

it('returns ok on health check', function (): void {
    /** @var TestResponse<Response> $response */
    $response = $this->getJson('/api/v1/health');

    $response->assertStatus(200)
        ->assertJson(['status' => 'ok', 'version' => 'v1']);
});
