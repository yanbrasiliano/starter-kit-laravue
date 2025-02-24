<?php

namespace App\Repositories\Contracts;

use App\DTO\Paginate\PaginateParamsDTO;
use App\Models\{DeleteReason, User};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\{Collection, Model};

interface UserRepositoryInterface
{
    public function list(PaginateParamsDTO $params): LengthAwarePaginator|Collection;

    public function create(array $params): Model|User;

    public function getById(int $id): Model|User;

    public function update(int $id, array $params): Model|User;

    public function delete(int $id, string $reason): DeleteReason;

    public function updatePassword(int $id, string $password): void;

    public function verify(int $id): void;
}
