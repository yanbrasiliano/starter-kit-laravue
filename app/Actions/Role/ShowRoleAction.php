<?php

declare(strict_types = 1);

namespace App\Actions\Role;

use Spatie\Permission\Models\Role;

final class ShowRoleAction
{
    public function execute(Role $role): Role
    {
        $role->load('permissions');

        $role->setAttribute('mapped_permissions', $role->permissions->map(fn ($permission) => [
            'value' => $permission->id,
            'label' => $permission->description,
        ]));

        return $role;
    }
}
