<?php

declare(strict_types = 1);

namespace App\Actions\Role;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Fluent;
use Spatie\Permission\Models\Role;

final class ListRoleAction
{
    public function execute(Fluent $params): LengthAwarePaginator|Collection
    {

        return Role::query()
            ->with('permissions')
            ->when($params->order, function ($query) use ($params) {
                $column = $params->column ?? 'id';
                $query->orderBy($column, $params->order);
            })
            ->when($params->paginated, function ($query) use ($params) {
                return $query->paginate($params->limit ?? 10);
            }, function ($query) {
                return $query->get();
            });
    }
}
