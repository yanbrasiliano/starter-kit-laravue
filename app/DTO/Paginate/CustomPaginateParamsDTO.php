<?php

namespace App\DTO\Paginate;

use App\DTO\AbstractDTO;

class CustomPaginateParamsDTO extends AbstractDTO
{
    public function __construct(
        public readonly ?int $rowsPerPage = 10,
        public readonly ?int $page = 1,
        public readonly ?string $sortBy = 'id',
        public readonly ?string $search = null,
        public readonly ?string $sortOrder = 'ASC',
        public readonly ?bool $descending = false,
        public readonly ?int $rowsNumber = null
    ) {
    }
}
