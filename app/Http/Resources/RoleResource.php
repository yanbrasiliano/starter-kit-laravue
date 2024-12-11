<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property array<array{id: int, description: string}> $permissions
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
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        return collect($this->permissions)->map(function ($permission) use ($user) {
            $value = $user->hasRole($this->id) ? $permission['id'] : null;

            return [
                'value' => $value,
                'label' => $permission['description'],
            ];
        })->toArray();
    }

}
