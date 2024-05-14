<?php

namespace App\Repositories\Contracts;

use App\DTO\Paginate\CustomPaginateParamsDTO;
use App\DTO\Role\CreateRoleDTO;
use App\DTO\Role\UpdateRoleDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

interface RoleRepositoryInterface
{
    public function list(CustomPaginateParamsDTO $paramsDTO): LengthAwarePaginator;

    public function create(CreateRoleDTO $role): Model|Role;

    public function getById(int $id): Model|Role;

    public function update(UpdateRoleDTO $role): Model|Role;

    public function delete(int $id): bool;

    public function getBySlug(string $slug): Model|Role;

    public function listAll(): Collection;
}
