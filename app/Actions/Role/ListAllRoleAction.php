<?php

declare(strict_types = 1);

namespace App\Actions\Role;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

final readonly class ListAllRoleAction
{
    public function execute(): Collection
    {
        return Role::with('permissions')->get();
    }
}
