<?php

namespace App\DTO\Authenticate;

use App\DTO\AbstractDTO;

/**
 * @extends AbstractDTO<array-key, mixed>
 */
class MyProfileDTO extends AbstractDTO
{
    /**
     * @param array<int, string> $permissions
     * @param array<int, string> $roles
     */
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly array $permissions,
        public readonly array $roles
    ) {
    }
}
