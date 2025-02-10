<?php

declare(strict_types = 1);

namespace App\Actions\Role;

use App\Traits\LogsActivityTrait;
use Spatie\Permission\Models\Role;

final class DeleteRoleAction
{
    use LogsActivityTrait;

    public function execute(Role $role): bool
    {
        try {
            $role->load('permissions');
            $role->permissions()->detach();
            $clonedRole = $role->replicate();
            $role->deleteOrFail();

            $this->logDeleteActivity('Gestão de Perfis', $clonedRole, 'Excluiu um perfil');

            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to delete role: ' . $e->getMessage());

            return false;
        }
    }
}
