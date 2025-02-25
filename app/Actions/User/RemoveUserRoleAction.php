<?php

declare(strict_types = 1);

namespace App\Actions\User;

use App\Models\User;

final readonly class RemoveUserRoleAction
{
    public function execute(User $user): void
    {
        $user->load('roles');

        $hasRoles = !$user->getRoleNames()->isEmpty();

        if ($hasRoles) {
            $user->getRoleNames()->each(fn ($role) => $user->removeRole($role));
        }
    }

    public static function make(): self
    {
        return new self();
    }
}
