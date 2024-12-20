<?php

namespace App\DTO\User;

use App\DTO\AbstractDTO;

/**
 * @extends AbstractDTO<array-key, mixed>
 */
class UserDTO extends AbstractDTO
{
    /**
     * @param array<int, array<string, mixed>> $roles
     */
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $cpf,
        public readonly int $active = 0,
        public readonly ?string $email_verified_at = '',
        public readonly string $created_at = '',
        public readonly string $updated_at = '',
        public readonly array $roles = []
    ) {
    }
}
