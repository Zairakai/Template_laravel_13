<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseRequest extends FormRequest
{
    /**
     * JSON on AJAX (Accept: application/json), native redirect otherwise.
     */
    protected function failedAuthorization(): never
    {
        if (! $this->expectsJson()) {
            parent::failedAuthorization();
        }

        throw new HttpResponseException(
            response()
                ->json(
                    [
                        'status'  => 'error',
                        'message' => 'This action is unauthorized.',
                    ],
                    Response::HTTP_FORBIDDEN,
                ),
        );
    }

    /**
     * JSON on AJAX (Accept: application/json), redirect back with errors otherwise.
     */
    protected function failedValidation(Validator $validator): never
    {
        if (! $this->expectsJson()) {
            parent::failedValidation($validator);
        }

        throw new HttpResponseException(
            response()
                ->json(
                    [
                        'status'  => 'error',
                        'message' => 'Validation failed.',
                        'errors'  => $validator->errors()->toArray(),
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                ),
        );
    }
}
