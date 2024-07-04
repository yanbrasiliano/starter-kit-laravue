<?php

namespace App\Services\Authenticate;

use App\DTO\Authenticate\{LoginDTO, MyProfileDTO};
use App\Exceptions\{InvalidCredentialsException, UnactivatedUserException};
use Illuminate\Support\Facades\{Auth, Session};

class AuthenticateService
{
    public function login(LoginDTO $dto)
    {
        $credentials = ['email' => $dto->email, 'password' => $dto->password];

        if (!Auth::guard('web')->attempt($credentials)) {
            throw new InvalidCredentialsException();
        }

        if (!Auth::user()->active) {
            throw new UnactivatedUserException();
        }
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        Session::regenerate();

        $token = $user->createToken('API Token')->plainTextToken;

        return $this->respondWithToken($token, $user);
    }

    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'user' => $user,
            'access_token' => $token,
        ]);
    }

    public function logout()
    {

        /**
         * @var \App\Models\User $user
         */
        $user = auth()->user();

        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        Session::invalidate();
        Session::regenerate();

        if ($user) {
            $user->tokens()->delete();
        }

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function myProfile(): MyProfileDTO
    {
        /**
         * @var \App\Models\User $user
         */
        $user = auth()->user();

        return new MyProfileDTO(...array_merge(
            $user->only('name', 'email'),
            [
                'permissions' => $user->getAllPermissions()->toArray(),
                'roles' => $user->roles()->get(['id', 'name'])->toArray(),

            ]
        ));
    }
}
