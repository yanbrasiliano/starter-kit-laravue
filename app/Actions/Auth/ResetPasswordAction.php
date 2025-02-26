<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\{Password};
use Illuminate\Support\Fluent;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordAction
{
    /**
     * Send the password reset link to the user.
     *
     * @param  \Illuminate\Support\Fluent  $params
     * @return void
     */
    public function execute(Fluent $params): void
    {
        try {
            $status = Password::reset(
                $params->toArray(),
                function ($user, string $password) {
                    User::findOrFail($user->id)->update(['password' => $password]);
                }
            );

            if ($status != Password::PASSWORD_RESET) {
                throw new \Exception(
                    'Não foi possível realizar a troca de senha, por favor tente novamente mais tarde.',
                    Response::HTTP_BAD_REQUEST
                );
            }
        } catch (\Throwable $throwable) {
            throw $throwable;
        }
    }
}
