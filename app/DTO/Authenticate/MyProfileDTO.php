<?php

namespace App\DTO\Authenticate;

use App\DTO\AbstractDTO;

class MyProfileDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly array $permissions,
        public readonly array $roles
    ) {
    }
}
