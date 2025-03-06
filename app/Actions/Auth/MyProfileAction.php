<?php

declare(strict_types = 1);

namespace App\Actions\Auth;

final readonly class MyProfileAction
{
    /**
     * @return array<string, mixed>
     */
    public function execute(): array
    {
        /**
         * @var \App\Models\User $user
         */
        $user = auth()->user();

        return [
            'name' => $user->name,
            'email' => $user->email,
            'permissions' => $user->getAllPermissions()->toArray(),
            'roles' => $user->roles()->get(['id', 'name'])->toArray(),
        ];
    }
}
