<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function index(User $user): bool
    {
        return $user->can('users.list');
    }

    public function create(User $user): bool
    {
        return $user->can('users.create');
    }

    public function show(User $user): bool
    {
        return $user->can('users.show');
    }

    public function update(User $user): bool
    {
        return $user->can('users.update');
    }

    public function delete(User $user): bool
    {
        return $user->can('users.delete');
    }
}