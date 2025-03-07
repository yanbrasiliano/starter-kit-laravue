<?php

declare(strict_types = 1);

namespace App\Actions\Permission;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

final readonly class PermissionListAction
{
    /**
     * @return Collection<int, Permission>
     */
    public function execute(): Collection
    {
        return Permission::all();
    }
}
