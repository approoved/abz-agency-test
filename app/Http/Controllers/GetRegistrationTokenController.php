<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\RegistrationToken;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetRegistrationTokenController extends Controller
{
    public function __invoke(): JsonResponse
    {
        /** @var RegistrationToken $token */
        $token = RegistrationToken::query()->create([
            'token' => Str::random(100),
            'expired_at' => Carbon::now()->addMinutes(40)
        ]);

        return response()->json(['token' =>$token->token]);
    }
}
