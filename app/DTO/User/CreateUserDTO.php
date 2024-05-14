<?php

namespace App\DTO\User;

use App\DTO\AbstractDTO;

class CreateUserDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly int $role_id,
        public readonly ?string $cpf = null,
        public readonly ?string $password = null,
        public readonly int $active = 0,
        public readonly int $send_random_password = 0
    ) {
    }
}
