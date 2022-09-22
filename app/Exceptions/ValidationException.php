<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

final class ValidationException extends Exception
{
    public function __construct(protected Validator $validator)
    {
        parent::__construct();
    }

    public function render(): JsonResponse
    {
        return response()->json(
            [
            'success' => 'false',
            'message' => 'Validation failed',
            'fails' => [$this->validator->errors()->messages()],
            ],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
