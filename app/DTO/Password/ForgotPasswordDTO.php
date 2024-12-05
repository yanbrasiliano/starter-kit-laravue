<?php

namespace App\DTO\Password;

use App\DTO\AbstractDTO;

/**
 * @extends AbstractDTO<array-key, mixed>
 */
class ForgotPasswordDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $email,
    ) {
    }
}
