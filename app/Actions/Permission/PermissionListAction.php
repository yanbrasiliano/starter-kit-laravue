<?php

declare(strict_types = 1);

namespace App\Actions\Permission;

use Illuminate\Support\Collection;
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
