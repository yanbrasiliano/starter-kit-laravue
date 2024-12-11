<?php

namespace App\Services\Role;

use App\DTO\Paginate\PaginateParamsDTO;
use App\DTO\Role\{CreateRoleDTO, UpdateRoleDTO};
use App\Exceptions\RoleIsAssignedToUserException;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Support\Facades\{Auth, DB};
use Spatie\Permission\Models\Role;

class RoleService
{
    public function __construct(
        private RoleRepositoryInterface $repository
    ) {
    }

    public function index(PaginateParamsDTO $paramsDTO)
    {
        return $this->repository->list($paramsDTO);
    }

    public function create(CreateRoleDTO $roleDto): Role
    {
        return DB::transaction(function () use ($roleDto) {
            return $this->repository->create($roleDto);
        });
    }

    public function getById(int $id): Role
    {
        $role = $this->repository->getById($id);

        return $role->load(['permissions:id,description']);
    }

    public function update(UpdateRoleDTO $roleDTO): Role
    {
        $user = Auth::user();
        $roleDTO->permissions = $user->hasRole($roleDTO->id) ? null : $roleDTO->permissions;

        return DB::transaction(function () use ($roleDTO) {
            return $this->repository->update($roleDTO);
        });
    }

    public function delete(int $id): bool
    {
        $this->repository->hasUsersWithProfile($id) ? throw new RoleIsAssignedToUserException() : null;

        return $this->repository->delete($id);
    }

    public function getBySlug(string $slug): Role
    {
        return $this->repository->getBySlug($slug);
    }

    public function listAll()
    {
        return $this->repository->listAll();
    }
}
