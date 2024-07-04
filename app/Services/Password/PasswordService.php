<?php

namespace App\Services\Password;

use App\DTO\Password\{ForgotPasswordDTO, ResetPasswordDTO};
use App\Enums\RolesEnum;
use App\Mail\SendForgetPasswordMail;
use App\Services\User\UserService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\{DB, Mail, Password};
use Throwable;

class PasswordService
{
    public function __construct(
        private UserService $userService
    ) {
    }

    public function forgotPassword(ForgotPasswordDTO $forgotPasswordDTO): void
    {
        DB::beginTransaction();

        try {
            $status = Password::sendResetLink(
                $forgotPasswordDTO->toArray(),
                $this->handleResetLinkSent()
            );

            if ($status !== Password::RESET_LINK_SENT) {
                throw new \Exception(
                    'Não foi possível realizar a solicitação de redefinição de senha, verifique se os dados informados são válidos.',
                    Response::HTTP_BAD_REQUEST
                );
            }

            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();

            throw $throwable;
        }
    }

    protected function handleResetLinkSent(): \Closure
    {
        return function ($user, string $token) {
            if (!$user->roles->where('slug', RolesEnum::REVIEWER->value)->count()) {
                throw new \Exception(
                    'Usuário não disponível para solicitar a redefinição de senha.',
                    Response::HTTP_CONFLICT
                );
            }

            Mail::to($user)->queue(new SendForgetPasswordMail($token, $user));
        };
    }

    public function resetPassword(ResetPasswordDTO $resetPasswordDTO): void
    {
        try {
            $status = Password::reset(
                $resetPasswordDTO->toArray(),
                $this->resetPasswordCallback()
            );

            if ($status != Password::PASSWORD_RESET) {
                throw new \Exception(
                    'Não foi possível realizar a troca de senha, por favor tente novamente mais tarde.',
                    Response::HTTP_BAD_REQUEST
                );
            }
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    protected function resetPasswordCallback(): \Closure
    {
        return function ($user, string $password) {
            $this->userService->updatePassword(
                $user?->id,
                $password
            );
        };
    }
}
