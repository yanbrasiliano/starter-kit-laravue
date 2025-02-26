<?php

declare(strict_types = 1);

namespace App\Actions\Auth;

use App\Exceptions\{InvalidCredentialsException, UnactivatedUserException};
use Illuminate\Support\Facades\{Auth, Session};
use Illuminate\Support\Fluent;

final readonly class LoginAction
{
    /**
     * @param \Illuminate\Support\Fluent&object{
     *     email: string,
     *     password: string
     * } $params
     */

    public function execute(Fluent $params): array
    {
        $credentials = ['email' => $params->email, 'password' => $params->password];

        throw_if(!Auth::guard('web')->attempt($credentials), InvalidCredentialsException::class);
        throw_if(!Auth::user()->active, UnactivatedUserException::class);
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        Session::regenerate();

        $token = $user->createToken('API Token')->plainTextToken;

        return [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'access_token' => $token,
        ];
    }
}
