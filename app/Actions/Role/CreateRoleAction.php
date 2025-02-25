<?php

declare(strict_types = 1);

namespace App\Actions\Role;

use App\Traits\LogsActivityTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Fluent;
use Spatie\Permission\Models\Role;

final readonly class CreateRoleAction
{
    use LogsActivityTrait;
    /**
     * @param \Illuminate\Support\Fluent&object{
     *     name: string,
     *     guard: string,
     *     description: string,
     *     slug: string,
     *     permissions: array
     * } $params
     * @return Spatie\Permission\Models\Role|null
     */
    public function execute(Fluent $params): ?Role
    {
        return DB::transaction(function () use ($params) {
            $role = Role::create([
                'name' => $params->name,
                'guard_name' => 'web',
                'slug' => str()->slug($params->name),
                'description' => $params->description,
            ]);

            $role->syncPermissions($params->permissions);

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
