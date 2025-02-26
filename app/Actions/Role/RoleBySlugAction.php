<?php

declare(strict_types = 1);

namespace App\Actions\Role;

use Spatie\Permission\Models\Role;

final readonly class RoleBySlugAction
{
    public function execute(string $slug, bool $withPermissions = false): Role
    {
        $role = Role::where('slug', $slug)->firstOrFail();

        if ($withPermissions) {
            $role->load('permissions');

            $role->setAttribute('mapped_permissions', $role->permissions->map(fn ($permission) => [
                'value' => $permission->id,
                'label' => $permission->description,
            ]));
        }

        return $role;
    }
}
