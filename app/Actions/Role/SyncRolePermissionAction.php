<?php

declare(strict_types = 1);

namespace App\Actions\Role;

use Spatie\Permission\Models\Role;

final class SyncRolePermissionAction
{
    /**
     * @param Role $role
     * @param array<int|array{value: int, label: string}>| array<int> $permissions
     */
    public function __construct(
        private readonly Role $role,
        private readonly array $permissions
    ) {
    }

    public function execute(): void
    {
        $permissions = $this->normalizePermissions();
        $this->role->syncPermissions($permissions);
    }

    /**
     * @return array<int>
     */
    private function normalizePermissions(): array
    {
        return collect($this->permissions)
            ->map(function (mixed $permission): ?int {
                if (is_numeric($permission)) {
                    return (int) $permission;
                }

                return is_array($permission) && isset($permission['value'])
                    ? (int) $permission['value']
                    : null;
            })
            ->filter()
            ->values()
            ->toArray();
    }
}
