<?php

namespace App\DTO\Permissions;

use App\DTO\AbstractDTO;

class PermissionDTO extends AbstractDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        // @phpstan-ignore-next-line
        private readonly string $guard_name,
        public readonly string $description,
        public readonly string $resource,
        public readonly string $created_at = '',
        public readonly string $updated_at = '',
    ) {
    }
}
