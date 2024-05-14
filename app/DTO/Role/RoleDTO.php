<?php

namespace App\DTO\Role;

use App\DTO\AbstractDTO;

class RoleDTO extends AbstractDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        // @phpstan-ignore-next-line
        private readonly string $guard_name,
        // @phpstan-ignore-next-line
        private readonly string $slug,
        public readonly string $description,
        public readonly array $permissions = [],
        public readonly string $created_at = '',
        public readonly string $updated_at = '',
    ) {
    }
}
