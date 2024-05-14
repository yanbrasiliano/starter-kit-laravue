<?php

namespace App\DTO\Authenticate;

use App\DTO\AbstractDTO;

class LoginDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {
    }
}
