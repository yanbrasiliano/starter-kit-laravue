<?php

namespace App\DTO\User;

use App\DTO\AbstractDTO;

/**
 * @extends AbstractDTO<array-key, mixed>
 */
class UpdateUserDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly int $active,
        public readonly ?string $cpf,
        public readonly ?string $password = null,
        public readonly ?string $created_at = null,
        public readonly ?int $role_id = null,
        public readonly ?string $role_slug = null,
        public readonly ?int $notify_status = null,
        public ?bool $send_random_password = null
    ) {
    }
}
