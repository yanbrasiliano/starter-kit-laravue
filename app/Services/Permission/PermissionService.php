<?php

namespace App\Services\Permission;

use App\Repositories\Contracts\PermissionRepositoryInterface;

class PermissionService
{
    public function __construct(
        private PermissionRepositoryInterface $repository
    ) {
    }

    public function index()
    {
        $permissions = $this->repository->list();

        return $permissions;
    }
}
