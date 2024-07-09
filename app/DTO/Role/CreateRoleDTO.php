<?php

namespace App\DTO\Role;

use App\DTO\AbstractDTO;

class CreateRoleDTO extends AbstractDTO
{
  public function __construct(
    public readonly string $name,
    public readonly ?string $description,
    public readonly ?array $permissions
  ) {
  }
}
