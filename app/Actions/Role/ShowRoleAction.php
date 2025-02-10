<?php

declare(strict_types = 1);

namespace App\Actions\Role;

use App\Traits\LogsActivityTrait;
use Spatie\Permission\Models\Role;

final class ShowRoleAction
{
    use LogsActivityTrait;

    public function execute(Role $role): Role
    {
        $role->load('permissions');

        $role->setAttribute('mapped_permissions', $role->permissions->map(fn ($permission) => [
            'value' => $permission->id,
            'label' => $permission->description,
        ]));

        $this->logGeneralActivity('Gestão de Perfis', $role, 'Visualizou os detalhes do perfil');

        return $role;
    }
}
