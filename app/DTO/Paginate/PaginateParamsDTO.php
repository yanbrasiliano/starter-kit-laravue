<?php

namespace App\DTO\Paginate;

use App\DTO\AbstractDTO;

class PaginateParamsDTO extends AbstractDTO
{
    public function __construct(
        public readonly ?string $name = '',
        public readonly ?int $limit = 10,
        public readonly ?int $page = 1,
        public readonly ?string $order = 'desc',
        public readonly ?string $column = 'id',
        public readonly ?string $search = null,
        public readonly ?int $paginated = 1,
    ) {
    }
}
