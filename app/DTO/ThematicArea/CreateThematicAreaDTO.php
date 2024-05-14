<?php

namespace App\DTO\ThematicArea;

use App\DTO\AbstractDTO;

class CreateThematicAreaDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $description,
    ) {
    }
}
