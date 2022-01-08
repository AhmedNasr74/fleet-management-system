<?php

namespace App\Http\Controllers\Users\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\LoginRequest;
use App\Http\Resources\Users\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        if (auth()->validate($request->validated())) {
            $user = User::whereEmail($request->get('email'))->first();
            $user->tokens()->delete();
            $user->setAttribute('token', $user->createToken($user->email . ' Access Token')->accessToken);
            return $this->apiResponseService->send(new UserResource($user), 'Logged In Successfully');
        }
        return $this->apiResponseService->sendMessage('Invalid Email/Password', Response::HTTP_BAD_REQUEST);
    }
}
