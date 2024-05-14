<?php

namespace App\Repositories\Contracts;

use App\Models\DeleteReason;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
{
    public function list(array $params): LengthAwarePaginator;

    public function create(array $params): Model|User;

    public function getById(int $id): Model|User;

    public function update(int $id, array $params): Model|User;

    public function delete(int $id, string $reason): DeleteReason;

    public function updatePassword(int $id, string $password): void;

    public function verify(int $id): void;
}
