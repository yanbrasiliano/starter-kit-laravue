<?php

namespace App\Repositories\Contracts;

use App\DTO\Paginate\PaginateParamsDTO;
use App\DTO\ThematicArea\CreateThematicAreaDTO;
use App\DTO\ThematicArea\UpdateThematicAreaDTO;
use App\Models\ThematicArea;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface ThematicAreaRepositoryInterface
{
    public function list(PaginateParamsDTO $requestDTO): LengthAwarePaginator;

    public function create(CreateThematicAreaDTO $CreateThematicAreaDTO): Model|ThematicArea;

    public function getById(int $id): Model|ThematicArea;

    public function update(int $id, UpdateThematicAreaDTO $UpdateThematicAreaDTO): Model|ThematicArea;

    public function delete(int $id): void;
}
