<?php

namespace App\DTO\Role;

use App\DTO\AbstractDTO;

class UpdateRoleDTO extends AbstractDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $description,
        public ?array $permissions,
    ) {
    }
}
