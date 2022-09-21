<?php

namespace App\Http\Controllers;

use App\Models\UserPosition\UserPosition;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetUserPositionListController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'positions' => UserPosition::all()
        ]);
    }
}
