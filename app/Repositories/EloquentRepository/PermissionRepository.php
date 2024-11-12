<?php

namespace App\Repositories\EloquentRepository;

use App\Repositories\AbstractRepository;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends AbstractRepository implements PermissionRepositoryInterface
{
    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    public function list()
    {
        return Permission::all();
    }
}
