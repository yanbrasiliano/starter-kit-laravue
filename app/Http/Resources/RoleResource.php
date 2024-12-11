<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property array<int, array<string, mixed>> $permissions
 * @property mixed $created_at
 * @property string $guard_name
 *
 * @phpstan-consistent-constructor
 **/
class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'shortDescription' => Str::words($this->description, 6, '...'),
            'createdAt' => $this->created_at,
            'permissions' => $this->getPermissionsForSelect(),
        ];
    }

    /**
     * Get permissions formatted for a select field.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function getPermissionsForSelect(): array
    {
        $permissions = collect($this->permissions);

        if ($permissions->isEmpty()) {
            return [];
        }

        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        return $permissions->map(fn($permission) => [
            'value' => $user->hasRole($this->id) ? null : ($permission['id'] ?? null),
            'label' => $permission['description'] ?? '',
        ])->filter(fn($permission) => $permission['label'] !== '' && $permission['value'] !== null)
            ->toArray();
    }

}
