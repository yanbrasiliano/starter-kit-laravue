<?php

namespace App\DTO\Role;

use App\DTO\AbstractDTO;

/**
 * @extends AbstractDTO<array-key, mixed>
 */
class CreateRoleDTO extends AbstractDTO
{
    /**
     * @param array<int, string>|null $permissions
     */
    public function __construct(
        public readonly string $name,
        public readonly ?string $description,
        public readonly ?array $permissions
    ) {
    }
}
