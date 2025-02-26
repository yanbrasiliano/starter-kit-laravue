<?php

declare(strict_types = 1);

namespace App\Actions\User;

use App\Models\User;

final readonly class ShowUserAction
{
    public function execute(mixed $id): ?User
    {
        return User::with(['roles.permissions'])->findOrFail($id);
    }
}
