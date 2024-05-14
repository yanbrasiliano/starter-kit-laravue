<?php

namespace App\DTO\Unit;

use App\DTO\AbstractDTO;

class UnitDTO extends AbstractDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $description,
        public readonly string $acronym,
        public readonly string $created_at,
        public readonly string $updated_at,
    ) {
    }
}
