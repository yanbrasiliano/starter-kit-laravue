<?php

declare(strict_types = 1);

namespace App\Repositories\EloquentRepository;

use App\Repositories\AbstractRepository;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends AbstractRepository implements PermissionRepositoryInterface
{
    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    /**
     * @return Collection<int, Permission>
     */
    public function list(): Collection
    {
        return Permission::all();
    }
}
