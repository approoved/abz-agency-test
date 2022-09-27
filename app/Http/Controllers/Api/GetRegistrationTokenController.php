<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Models\RegistrationToken\RegistrationToken;

final class GetRegistrationTokenController extends Controller
{
    public function __invoke(): JsonResponse
    {
        /** @var RegistrationToken $token */
        $token = RegistrationToken::query()->create([
            'token' => Str::random(100),
            'expired_at' => Carbon::now()->addMinutes(40),
        ]);

        return response()->json([
            'success' => true,
            'token' =>$token->token,
        ]);
    }
}
