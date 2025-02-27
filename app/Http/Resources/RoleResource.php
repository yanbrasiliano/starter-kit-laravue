<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\{Collection, Str};

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property Collection<int, array{id: int, description: string}> $permissions
 * @property \Illuminate\Support\Carbon $created_at
 * @property string $guard_name
 *
 * @phpstan-consistent-constructor
 */
class RoleResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
            'shortDescription' => Str::words($this->description, 6, '...'),
            'createdAt' => $this->created_at,
            'permissions' => $this->getPermissionsForSelect(),
        ];
    }

    /**
     * Retrieve permissions formatted for a select field.
     *
     * @return array<array{value: int|null, label: string}>
     */
    protected function getPermissionsForSelect(): array
    {
        return collect($this->permissions)
            ->map(fn (array $permission) => [
                'value' => $permission['id'],
                'label' => $permission['description'],
            ])
            ->toArray();
    }
}
