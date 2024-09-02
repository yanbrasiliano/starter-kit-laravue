<?php

namespace App\Repositories\Contracts;

use App\DTO\Paginate\PaginateParamsDTO;
use App\DTO\Role\{CreateRoleDTO, UpdateRoleDTO};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\{Collection, Model};
use Spatie\Permission\Models\Role;

interface RoleRepositoryInterface
{
  public function list(PaginateParamsDTO $paramsDTO): LengthAwarePaginator|Collection;

  public function create(CreateRoleDTO $role): Model|Role;

  public function getById(int $id): Model|Role;

  public function update(UpdateRoleDTO $role): Model|Role;

  public function delete(int $id): bool;

  public function getBySlug(string $slug): Model|Role;

  public function listAll(): Collection;

  public function hasUsersWithProfile(int $id): bool;
}
