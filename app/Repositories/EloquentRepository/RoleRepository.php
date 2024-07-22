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

class RoleRepository extends AbstractRepository implements RoleRepositoryInterface
{
    public function __construct(private Role $role)
    {
        $this->role = $role;
    }

    public function list(CustomPaginateParamsDTO $paramsDTO): LengthAwarePaginator
    {
        return $this->role->query()
          ->when($paramsDTO->search, fn ($query) => $query->where('name', 'ilike', "%{$paramsDTO->search}%")
            ->orWhere('description', 'ilike', "%{$paramsDTO->search}%"))
          ->when($paramsDTO->sortBy, fn ($query) => $query->orderBy($paramsDTO->sortBy, $paramsDTO->sortOrder))
          ->with('permissions')
          ->paginate($paramsDTO->rowsPerPage);
    }

    public function create(CreateRoleDTO $roleDTO): Model|Role
    {
        return DB::transaction(fn () => tap(
            $this->role->create([
                'name' => $roleDTO->name,
                'guard_name' => 'web',
                'slug' => str()->slug($roleDTO->name),
                'description' => $roleDTO->description,
            ]),
            fn ($role) => $role->syncPermissions($roleDTO->permissions)
        ));
    }

    public function getById(int $id): Model|Role
    {
        return $this->role->with(['permissions' => function ($query) {
            return $query->select(['id', 'description']);
        }])->findOrFail($id);
    }

    public function update(UpdateRoleDTO $roleDTO): Model|Role
    {
        return DB::transaction(fn () => tap($this->role->findOrFail($roleDTO->id), function ($role) use ($roleDTO) {
            $role->update([
                'name' => $roleDTO->name,
                'guard_name' => 'web',
                'slug' => str()->slug($roleDTO->name),
                'description' => $roleDTO->description,
            ]);

            $roleDTO->permissions ? $role->syncPermissions($roleDTO->permissions) : null;
        }));
    }

    public function delete(int $id): bool
    {
        return $this->role->findOrFail($id)->delete();
    }

    public function getBySlug(string $slug): Model|Role
    {
        return $this->role->with(['permissions' => function ($query) {
            return $query->select(['id', 'description']);
        }])->where('slug', $slug)->firstOrFail();
    }

    public function listAll(): Collection
    {
        return $this->role->with('permissions')->get(['id', 'name']);
    }
}
