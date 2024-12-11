<?php

namespace App\Repositories\EloquentRepository;

use App\DTO\Paginate\PaginateParamsDTO;
use App\DTO\Role\{CreateRoleDTO, UpdateRoleDTO};
use App\Repositories\AbstractRepository;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\{Collection, Model};
use Spatie\Permission\Models\Role;

class RoleRepository extends AbstractRepository implements RoleRepositoryInterface
{
    public function __construct(private Role $role)
    {
        $this->role = $role;
    }

    public function list(PaginateParamsDTO $paramsDTO): LengthAwarePaginator|Collection
    {
        return $this->role->query()
            ->with('permissions')
            ->when(isset($paramsDTO->order), function ($query) use ($paramsDTO) {
                $column = $paramsDTO->column ?? 'id';
                $query->orderBy($column, $paramsDTO->order);
            })
            ->when($paramsDTO->paginated, function ($query) use ($paramsDTO) {
                return $query->paginate($paramsDTO->limit ?? 10);
            }, function ($query) {
                return $query->get();
            });
    }

    public function hasUsersWithProfile(int $id): bool
    {
        return $this->role->findOrFail($id)->users()->exists();
    }
    public function create(CreateRoleDTO $roleDTO): Model|Role
    {
        return tap($this->role->create([
            'name' => $roleDTO->name,
            'guard_name' => 'web',
            'slug' => str()->slug($roleDTO->name),
            'description' => $roleDTO->description,
        ]), fn($role) => $role->syncPermissions($roleDTO->permissions));
    }
    public function getById(int $id): Model|Role
    {
        return $this->role->with([
            'permissions:id,description',
        ])->findOrFail($id);
    }
    public function update(UpdateRoleDTO $roleDTO): Model|Role
    {
        return tap($this->role->findOrFail($roleDTO->id), function ($role) use ($roleDTO) {
            $role->update([
                'name' => $roleDTO->name,
                'guard_name' => 'web',
                'description' => $roleDTO->description,
            ]);

            $roleDTO->permissions ? $role->syncPermissions($roleDTO->permissions) : null;
        });
    }
    public function delete(int $id): bool
    {
        return $this->role->findOrFail($id)->delete();
    }

    public function getBySlug(string $slug): Model|Role
    {
        return $this->role->with([
            'permissions' => function ($query) {
                return $query->select(['id', 'description']);
            },
        ])->where('slug', $slug)->firstOrFail();
    }

    public function listAll(): Collection
    {
        return $this->role->with('permissions')->get(['id', 'name', 'description', 'created_at']);
    }

}
