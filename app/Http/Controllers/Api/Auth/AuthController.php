<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Foundations\Routing\BaseApiController;

class AuthController extends BaseApiController
{
    public function login(Request $request): JsonResponse
    {
        $data = $this->validate($request, [
            'username' => 'required|min:6|max:20',
            'password' => 'required|min:8|max:30',
        ]);


        $loginType = filter_var($data['username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            'password' => $data['password'],
            $loginType => $data['username'],
        ];

        $user = User::where('email', $credentials['email'])->first();

        if($user === null || $user->status == 0) {
            $message = 'Your account is not active.';
            $data = [];

            return $this->msgResponse($message, 403);
        }

        if (! $token = auth('api')->attempt($credentials)) {
            return $this->msgResponse('Unauthorized', 401);
        }

        return $this->respondWithToken($token);

    }

    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        return $this->msgResponse('Successfully logged out');
    }

    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
