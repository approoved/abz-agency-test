<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

final class HttpException extends Exception
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
