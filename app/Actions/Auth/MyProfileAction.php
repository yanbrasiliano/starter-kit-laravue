<?php

declare(strict_types = 1);

namespace App\Actions\Auth;

final readonly class MyProfileAction
{
    public function execute(): array
    {
        /**
         * @var \App\Models\User $user
         */
        $user = auth()->user();

        return array_merge(
            $user->only('name', 'email'),
            [
                'permissions' => $user->getAllPermissions()->toArray(),
                'roles' => $user->roles()->get(['id', 'name'])->toArray(),

            ]
        );
    }
}
