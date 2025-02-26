<?php

declare(strict_types = 1);

namespace App\Actions\Auth;

use Illuminate\Support\Facades\{Auth, Session};

final readonly class LogoutAction
{
    public function execute(): array
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

        return ['message' => 'Volte Sempre'];
    }
}
