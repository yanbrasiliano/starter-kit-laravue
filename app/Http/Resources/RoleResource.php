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
 * @property array $permissions
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

    

    protected function getPermissionsForSelect()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        if ($user->hasRole($this->id) && $this->permissions) {
            return collect($this->permissions)->map(fn ($permission) => [
                'value' => null,
                'label' => $permission['description'],
            ]);
        }

        return collect($this->permissions)->map(fn ($permission) => [
            'value' => $permission['id'],
            'label' => $permission['description'],
        ]);
    }
}
