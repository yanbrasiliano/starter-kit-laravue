<?php

namespace App\DTO\Role;

use App\DTO\AbstractDTO;

/**
 * @extends AbstractDTO<array-key, mixed>
 */
class UpdateRoleDTO extends AbstractDTO
{
    /**
     * @param array<int, string> $permissions
     */
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $description,
        public ?array $permissions,
    ) {
    }
}
