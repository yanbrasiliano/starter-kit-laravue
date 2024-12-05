<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'permissions' => $this->getPermissionsForSelect($request),
        ];
    }

    /**
     * Get permissions formatted for a select field.
     *
     * @param Request $request
     * @return array<int, array<string, mixed>>
     */
    public function getPermissionsForSelect(Request $request): array
    {
        $permissions = parent::toArray($request);

        return collect(is_array($permissions) ? $permissions : (array) $permissions)
            ->map(function ($permission) {
                return [
                    'value' => $permission['id'],
                    'label' => $permission['description'],
                ];
            })
            ->toArray();
    }
}
