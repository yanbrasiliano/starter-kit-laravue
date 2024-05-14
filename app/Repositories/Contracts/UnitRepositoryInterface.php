<?php

namespace App\Repositories\Contracts;

use App\Models\Unit;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface UnitRepositoryInterface
{
    public function list(array $params): LengthAwarePaginator;

    public function create(array $params): Model|Unit;

    public function getById(int $id): Model|Unit;

    public function update(int $id, array $params): Model|Unit;

    public function delete(int $id): void;
}
