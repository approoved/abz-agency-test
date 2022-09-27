<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserPosition\UserPosition;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetUserPositionListController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'positions' => UserPosition::all(),
        ]);
    }
}
