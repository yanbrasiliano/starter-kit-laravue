<?php

namespace App\Actions\Permission;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

class PermissionListAction
{
    /**
     * @return Collection<int, Permission>
     */
    public function execute(): Collection
    {
        return Permission::all();
    }
}
