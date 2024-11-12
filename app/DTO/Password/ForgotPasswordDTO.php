<?php

namespace App\DTO\Password;

use App\DTO\AbstractDTO;

class ForgotPasswordDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $email,
    ) {
    }
}
