<?php

declare(strict_types = 1);

namespace App\Actions\Role;

use App\Traits\LogsActivityTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Fluent;
use Spatie\Permission\Models\Role;

final class UpdateRoleAction
{
    use LogsActivityTrait;

    public function execute(Role $role, Fluent $params): ?Role
    {
        return DB::transaction(function () use ($role, $params) {

            $role->update([
                'name' => $params->name,
                'description' => $params->description,
                'guard_name' => 'web',
            ]);

            (new SyncRolePermissionAction($role, $params->permissions))->execute();

            $this->logUpdateActivity('Gestão de Perfis', $role, $role->getDirty(), 'Atualizou um perfil');

            return $role;
        });
    }

}
