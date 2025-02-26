<?php

declare(strict_types = 1);

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Fluent;

final readonly class ListUserAction
{
    /**
     * @param \Illuminate\Support\Fluent&object{
     *     search: string,
     *     order: string,
     *     column: string,
     *     page: int,
     *     perPage: int
     * } $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function execute(Fluent $params): LengthAwarePaginator|Collection
    {
        $query = User::query();

        $query->select([
            'users.*',
            'roles.name as role',
            'role_user.role_id as role_id',
        ])
            ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
            ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id');

        $query->when($params->search, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('users.id', 'ilike', "%$search%")
                    ->orWhere('users.name', 'ilike', "%$search%")
                    ->orWhere('users.email', 'ilike', "%$search%")
                    ->orWhere('roles.name', 'ilike', "%$search%");
            });
        });

        $query->when($params->order, function ($query, $order) use ($params) {
            $column = match ($params->column) {
                'name' => 'users.name',
                'email' => 'users.email',
                'role' => 'roles.name',
                'setSituation' => 'users.active',
                default => 'users.id',
            };
            $query->orderBy($column, $order);
        });

        return $params->paginated ? $query->paginate($params->limit ?? 10) : $query->get();
    }
}
