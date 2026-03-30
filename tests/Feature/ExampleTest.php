<?php

declare(strict_types=1);

use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;

it('returns a successful response', function (): void {
    $this->withoutVite();

    /** @var TestResponse<Response> $response */
    $response = $this->get('/');

    $response->assertStatus(200);
});
