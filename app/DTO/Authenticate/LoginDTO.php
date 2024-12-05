<?php

namespace App\DTO\Authenticate;

use App\DTO\AbstractDTO;

/**
 * @extends AbstractDTO<array-key, mixed>
 */
class LoginDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {
    }
}
