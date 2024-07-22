<?php

namespace App\Services;

use App\DTO\Paginate\CustomPaginateParamsDTO;
use App\DTO\Role\{CreateRoleDTO, RoleDTO, UpdateRoleDTO};
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class RoleService
{
    public function __construct(
        private RoleRepositoryInterface $repository
    ) {
    }

    public function index(CustomPaginateParamsDTO $paramsDTO)
    {
        return $this->repository->list($paramsDTO);
    }

    public function create(CreateRoleDTO $roleDto): RoleDTO
    {
        return new RoleDTO(...$this->repository->create($roleDto)->toArray());
    }

    public function getById(int $id): RoleDTO
    {
        return new RoleDTO(...$this->repository->getById($id)->toArray());
    }

    public function update(UpdateRoleDTO $roleDTO): RoleDTO
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        $roleDTO->permissions = $user->hasRole($roleDTO->id) ? null : $roleDTO->permissions;

        return new RoleDTO(...$this->repository->update($roleDTO)->toArray());
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function getBySlug(string $slug): RoleDTO
    {
        return new RoleDTO(...$this->repository->getBySlug($slug)->toArray());
    }

    public function listAll()
    {
        return $this->repository->listAll();
    }
}
