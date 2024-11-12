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
        return $this->getPermissionsForSelect($request);
    }

    public function getPermissionsForSelect(Request $request)
    {
        $permissions = parent::toArray($request);

        return collect($permissions)->map(function ($permission) {
            return [
                'value' => $permission['id'],
                'label' => $permission['description'],
            ];
        })->toArray();
    }
}
