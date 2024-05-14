<?php

namespace App\Services;

use App\DTO\Paginate\CustomPaginateParamsDTO;
use App\DTO\Role\CreateRoleDTO;
use App\DTO\Role\RoleDTO;
use App\DTO\Role\UpdateRoleDTO;
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
        $role = $this->repository->create($roleDto);

        return new RoleDTO(...$role->toArray());
    }

    public function getById(int $id): RoleDTO
    {
        $role = $this->repository->getById($id);

        return new RoleDTO(...$role->toArray());
    }

    public function update(UpdateRoleDTO $roleDTO): RoleDTO
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        if ($user->hasRole($roleDTO->id)) {
            $roleDTO->permissions = null;
        }
        $role = $this->repository->update($roleDTO);

        return new RoleDTO(...$role->toArray());
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function getBySlug(string $slug): RoleDTO
    {
        $role = $this->repository->getBySlug($slug);

        return new RoleDTO(...$role->toArray());
    }

    public function listAll()
    {
        return $this->repository->listAll();
    }
}
