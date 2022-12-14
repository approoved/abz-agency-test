<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User\User;
use Illuminate\Http\Request;
use App\Services\Kraken\Kraken;
use Illuminate\Http\JsonResponse;
use App\Exceptions\HttpException;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\CreateUserRequest;
use App\Models\UserPosition\UserPosition;
use App\Http\Requests\RetrieveUserRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\UserResourceCollection;
use App\Models\RegistrationToken\RegistrationToken;

final class UserController extends Controller
{
    public const DEFAULT_COUNT = 5;

    public function store(CreateUserRequest $request, Kraken $kraken): JsonResponse
    {
        $this->authenticate($request);

        $data = $request->validated();

        $emailExists = User::query()->firstWhere('email', $data['email']);
        $phoneExists = User::query()->firstWhere('phone', $data['phone']);

        if ($emailExists || $phoneExists) {
            throw new HttpException(
                'User with this phone or email already exist.',
                Response::HTTP_CONFLICT
            );
        }

        /** @var UserPosition $position */
        $position = UserPosition::query()->firstWhere('id', $data['position_id']);

        if (! $position) {
            throw new HttpException(
                'Position not found.',
                Response::HTTP_NOT_FOUND
            );
        }

        $data['photo'] = $kraken->optimizeImageUpload($data['photo']);

        /** @var User $user */
        $user = User::query()->create($data);

        return response()->json(
            [
            'success' => true,
            'user_id' => $user->id,
            'message' => 'New user successfully registered',
            ],
            Response::HTTP_CREATED
        );
    }

    public function index(RetrieveUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $users = User::query()->with('position')->paginate(
            $data['count'] ?? self::DEFAULT_COUNT,
            page: $data['page'] ?? null
        );

        return response()->json(new UserResourceCollection($users));
    }

    public function show(int $id): JsonResponse
    {
        $user = User::query()
            ->where('id', $id)
            ->with('position')
            ->first();

        if (! $user) {
            throw new HttpException(
                'The user with the requested identifier does not exist.',
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json([
            'success' => true,
            'user' => new UserResource($user),
        ]);
    }

    private function authenticate(Request $request): void
    {
        $token = htmlspecialchars($request->header('Authorization'));

        /** @var RegistrationToken $token */
        $token = RegistrationToken::query()->firstWhere('token', $token);

        if (! $token) {
            throw new HttpException(code: Response::HTTP_UNAUTHORIZED);
        }

        if ($token->expired_at < Carbon::now()) {
            throw new HttpException(
                'The token expired.',
                Response::HTTP_UNAUTHORIZED
            );
        }

        $token->revoke();
    }
}
