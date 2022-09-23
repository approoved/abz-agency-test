<?php

namespace App\Http\Controllers;

use App\Models\UserPosition\UserPosition;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetUserPositionListController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'positions' => UserPosition::all()
        ]);
    }
}
