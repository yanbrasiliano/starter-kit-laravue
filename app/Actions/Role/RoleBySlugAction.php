<?php

declare(strict_types = 1);

namespace App\Actions\Role;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\{Permission, Role};

final readonly class RoleBySlugAction
{
    public function execute(string $slug, bool $withPermissions = false): Role
    {
        $role = Role::where('slug', $slug)->firstOrFail();

        if ($withPermissions) {
            $role->load('permissions');

            /** @var Collection<int, Permission> $permissions */
            $permissions = $role->permissions;

            $role->setAttribute(
                'mapped_permissions',
                $permissions->map(fn (Permission $permission): array => [
                    'value' => $permission->id,
                    'label' => $permission->getAttribute('description'),
                ])->all()
            );
        }

        return $role;
    }
}
