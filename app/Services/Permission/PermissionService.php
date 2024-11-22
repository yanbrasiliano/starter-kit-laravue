<?php

declare(strict_types=1);

namespace App\Services\Permission;

use App\Repositories\Contracts\PermissionRepositoryInterface;
use Illuminate\Support\Collection;

class PermissionService
{
  public function __construct(
    private PermissionRepositoryInterface $repository
  ) {}

  /**
   * Retrieve the list of permissions.
   *
   * @return Collection<int, \Spatie\Permission\Models\Permission>
   */
  public function index(): Collection
  {
    return $this->repository->list();
  }
}
