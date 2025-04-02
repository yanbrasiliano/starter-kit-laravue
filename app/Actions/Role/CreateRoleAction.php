<?php

declare(strict_types = 1);

namespace App\Actions\Role;

use App\Traits\LogsActivity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Fluent;
use Spatie\Permission\Models\Role;

final readonly class CreateRoleAction
{
    use LogsActivity;

    /**
     * @param Fluent<string, mixed> $params
     * @return Role
     */
    public function execute(Fluent $params): Role
    {
        return DB::transaction(function () use ($params): Role {
            /** @var Role $role */
            $role = Role::create([
                'name' => $params->get('name'),
                'guard_name' => 'web',
                'slug' => str()->slug($params->get('name')),
                'description' => $params->get('description'),
            ]);

            $role->syncPermissions($params->get('permissions', []));

            $this->writeOnLog($role); // TODO: Move to Event or Log

            return $role;
        });
    }

    private function writeOnLog(Role $role): void
    {
        $this->logGeneralActivity(
            activityName: 'Gestão de Perfis',
            model: $role,
            description: sprintf(
                'Criou um novo perfil "%s" com %d permissões',
                $role->name,
                $role->permissions()->count()
            ),
            event: 'create'
        );
    }
}
