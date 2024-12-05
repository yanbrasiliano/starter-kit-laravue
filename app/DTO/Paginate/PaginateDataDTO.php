<?php

namespace App\DTO\Paginate;

use App\DTO\AbstractDTO;

/**
 * @extends AbstractDTO<array-key, mixed>
 */
class PaginateDataDTO extends AbstractDTO
{
    /**
     * @param array<int, mixed> $data
     * @param array<int, array<string, mixed>> $links
     */
    public function __construct(
        public readonly ?int $current_page = null,
        public readonly array $data = [],
        public readonly ?string $first_page_url = null,
        public readonly ?int $from = null,
        public readonly ?int $last_page = null,
        public readonly array $links = [],
        public readonly ?string $next_page_url = null,
        public readonly ?string $path = null,
        public readonly ?string $last_page_url = null,
        public readonly ?int $per_page = null,
        public readonly ?string $prev_page_url = null,
        public readonly ?int $to = null,
        public readonly ?int $total = null,
    ) {
    }
}
