<?php

namespace App\DTO\ThematicArea;

use App\DTO\AbstractDTO;

class ThematicAreaDTO extends AbstractDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $description,
        public readonly string $created_at = '',
        public readonly string $updated_at = '',
    ) {
    }
}
