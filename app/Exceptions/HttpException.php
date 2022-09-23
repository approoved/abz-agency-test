<?php

namespace App\Exceptions;

use RuntimeException;
use Illuminate\Http\JsonResponse;

final class HttpException extends RuntimeException
{
    public function render(): JsonResponse
    {
        return response()->json(
            [
                'success' => false,
                'message' => $this->message,
            ],
            $this->code
        );
    }
}
