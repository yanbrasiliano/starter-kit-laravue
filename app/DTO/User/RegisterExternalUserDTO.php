<?php

namespace App\DTO\User;

use App\DTO\AbstractDTO;

/**
 * @extends AbstractDTO<array-key, mixed>
 */
class RegisterExternalUserDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $cpf,
        public readonly string $role,
        public readonly string $password,
        // @phpstan-ignore-next-line
        private readonly string $password_confirmation,
        public readonly int $active = 0,
    ) {
    }
}
