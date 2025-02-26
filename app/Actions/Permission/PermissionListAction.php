<?php

namespace App\Actions\Permission;

use Spatie\Permission\Models\Permission;

class PermissionListAction
{
    public function execute(): \Illuminate\Support\Collection
    {
        return Permission::all();
    }
}
