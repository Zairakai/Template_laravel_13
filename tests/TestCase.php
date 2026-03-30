<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert;

abstract class TestCase extends BaseTestCase
{
    /**
     * Assert the response matches the standard API error format.
     *
     * @param TestResponse<Response> $testResponse
     */
    protected function assertApiError(TestResponse $testResponse, int $status = 400): void
    {
        $testResponse->assertStatus($status);
        $testResponse->assertJsonStructure(['status', 'message']);
        $testResponse->assertJsonPath('status', 'error');
    }

    /**
     * Assert the response matches the standard API paginated format.
     *
     * @param TestResponse<Response> $testResponse
     */
    protected function assertApiPaginated(TestResponse $testResponse): void
    {
        $testResponse->assertStatus(200);
        $testResponse->assertJsonStructure([
            'status',
            'message',
            'data',
            'pagination' => ['current_page', 'total_pages', 'total_items', 'per_page'],
        ]);
        $testResponse->assertJsonPath('status', 'success');
    }

    /**
     * Assert the response matches the standard API success format.
     *
     * @param TestResponse<Response> $testResponse
     */
    protected function assertApiSuccess(TestResponse $testResponse, int $status = 200): void
    {
        $testResponse->assertStatus($status);
        $testResponse->assertJsonStructure(['status', 'message', 'data']);
        $testResponse->assertJsonPath('status', 'success');
    }

    /**
     * Assert the response is a 422 validation error with optional field checks.
     *
     * @param TestResponse<Response> $testResponse
     * @param list<string>           $fields
     */
    protected function assertApiValidationError(TestResponse $testResponse, array $fields = []): void
    {
        $testResponse->assertStatus(422);
        $testResponse->assertJsonStructure(['status', 'message', 'errors']);
        $testResponse->assertJsonPath('status', 'error');

        $errors = $testResponse->json('errors');

        Assert::assertIsArray($errors, 'Expected errors to be an array.');

        foreach ($fields as $field) {
            Assert::assertArrayHasKey(
                $field,
                $errors,
                "Expected validation error for field [{$field}].",
            );
        }
    }
}
