<?php

namespace App\DTO\Password;

use App\DTO\AbstractDTO;

class ResetPasswordDTO extends AbstractDTO
{
  public function __construct(
    public readonly string $email,
    public readonly string $token,
    public readonly string $password,
    public readonly string $password_confirmation,
  ) {
  }
}
