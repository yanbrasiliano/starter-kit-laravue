<?php

namespace App\Repositories\EloquentRepository;

use App\DTO\Paginate\CustomPaginateParamsDTO;
use App\DTO\Role\{CreateRoleDTO, UpdateRoleDTO};
use App\Repositories\AbstractRepository;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\{Collection, Model};
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Throwable;

class RoleRepository extends AbstractRepository implements RoleRepositoryInterface
{
    public function __construct(private Role $role)
    {
        $this->role = $role;
    }

    public function list(CustomPaginateParamsDTO $paramsDTO): LengthAwarePaginator
    {
        $query = $this->role->query();
        
        $query->when($paramsDTO->search, function () use ($paramsDTO, $query) {
            $query->where('name', 'ilike', "%{$paramsDTO->search}%")
                ->orWhere('description', 'ilike', "%{$paramsDTO->search}%");
        })->when($paramsDTO->sortBy, function () use ($paramsDTO, $query) {
            $query->orderBy($paramsDTO->sortBy, $paramsDTO->sortOrder);
        });
        
        return $query->paginate($paramsDTO->rowsPerPage);
    }

    public function create(CreateRoleDTO $roleDTO): Model|Role
    {
        DB::beginTransaction();

        try {
            $role = $this->role->create([
                'name' => $roleDTO->name,
                'guard_name' => 'web',
                'slug' => str()->slug($roleDTO->name),
                'description' => $roleDTO->description,
            ]);
            $role->syncPermissions($roleDTO->permissions);

            DB::commit();

            return $role;
        } catch (Throwable $throw) {
            DB::rollBack();

            throw $throw;
        }
    }

    public function getById(int $id): Model|Role
    {
        return $this->role->with(['permissions' => function ($query) {
            return $query->select(['id', 'description']);
        }])->findOrFail($id);
    }

    public function update(UpdateRoleDTO $roleDTO): Model|Role
    {
        DB::beginTransaction();

        try {

            $role = $this->role->findOrFail($roleDTO->id);

            $role->update([
                'name' => $roleDTO->name,
                'guard_name' => 'web',
                'slug' => str()->slug($roleDTO->name),
                'description' => $roleDTO->description,
            ]);

            if ($roleDTO->permissions !== null) {
                $role->syncPermissions($roleDTO->permissions);
            }

            DB::commit();

            return $role;
        } catch (Throwable $throw) {
            DB::rollBack();

            throw $throw;
        }
    }

    public function delete(int $id): bool
    {
        DB::beginTransaction();

        try {
            $role = $this->role->findOrFail($id);

            DB::commit();

            return $role->delete();
        } catch (Throwable $throw) {
            DB::rollBack();

            throw $throw;
        }
    }

    public function getBySlug(string $slug): Model|Role
    {
        return $this->role->with(['permissions' => function ($query) {
            return $query->select(['id', 'description']);
        }])->where('slug', $slug)->firstOrFail();
    }

    public function listAll(): Collection
    {
        return $this->role->all(['id', 'name']);
    }
}
