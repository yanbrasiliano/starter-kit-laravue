<?php

namespace App\DTO\Unit;

use App\DTO\AbstractDTO;

class CreateUnitDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $description,
        public readonly string $acronym,
    ) {
    }
}
