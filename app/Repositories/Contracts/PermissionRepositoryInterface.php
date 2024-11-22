<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface PermissionRepositoryInterface
{
  /**
   * Get all permissions.
   *
   * @return Collection<int, \Spatie\Permission\Models\Permission>
   */
  public function list(): Collection;
}
