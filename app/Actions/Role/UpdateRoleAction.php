<?php

declare(strict_types = 1);

namespace App\Actions\Role;

use App\Traits\LogsActivityTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Fluent;
use Spatie\Permission\Models\Role;

final readonly class UpdateRoleAction
{
    use LogsActivityTrait;

    /**
     * @param Fluent<string, mixed> $params
     */
    public function execute(Role $role, Fluent $params): Role
    {
        return DB::transaction(function () use ($role, $params): Role {
            $role->update([
                'name' => $params->get('name', $role->name),
                'description' => $params->get('description', $role->getAttribute('description')),
                'guard_name' => 'web',
            ]);

            $role->syncPermissions($params->get('permissions', []));

            $this->logUpdateActivity('Gestão de Perfis', $role, $role->getDirty(), 'Atualizou um perfil');

            return $role;
        });
    }
}
