<?php

declare(strict_types = 1);

namespace App\Actions\Role;

use Spatie\Permission\Models\Role;

final readonly class SyncRolePermissionAction
{
    public function __construct(private Role $role, private mixed $permissions)
    {
        //
    }
    public function execute(): void
    {
        $user = auth()->user();

        $permissions = collect($this->permissions)
                ->filter(fn ($permission) => fluent($permission)->value != null)
                ->pluck('value')
                ->toArray();

        $this->role->syncPermissions($permissions);
    }
}
