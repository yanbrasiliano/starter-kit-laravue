<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function index(User $user): bool
    {
        return $user->can('users.list');
    }
}
