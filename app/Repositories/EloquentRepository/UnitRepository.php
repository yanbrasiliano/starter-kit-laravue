<?php

namespace App\Repositories\EloquentRepository;

use App\Models\Unit;
use App\Repositories\AbstractRepository;
use App\Repositories\Contracts\UnitRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class UnitRepository extends AbstractRepository implements UnitRepositoryInterface
{
    public function __construct(Unit $unit)
    {
        $this->model = $unit;
    }

    public function list(array $params): LengthAwarePaginator
    {
        $query = $this->model->query();

        $query->select('units.*');

        if (isset($params['search']) && strlen($params['search'])) {
            $query->where('units.id', 'ilike', "%{$params['search']}%");
            $query->orWhere('units.description', 'ilike', "%{$params['search']}%");
            $query->orWhere('units.acronym', 'ilike', "%{$params['search']}%");
        }

        if (isset($params['order'])) {
            $column = $params['column'] ?? null;
            switch ($column) {
                case 'description':
                    $column = 'units.description';
                    break;

                case 'acronym':
                    $column = 'units.acronym';
                    break;

                default:
                    $column = 'units.id';
                    break;
            }

            $query->orderBy($column, $params['order']);
        }

        return $query->paginate(
            perPage: $params['limit'] ?? 10,
            page: $params['page'] ?? 1
        );
    }

    public function create(array $params): Model|Unit
    {
        return $this->model->create($params);
    }

    public function getById(int $id): Model|Unit
    {
        return $this->model->findOrFail($id);
    }

    public function update(int $id, array $params): Model|Unit
    {
        $unit = $this->model->findOrFail($id);
        $unit->update($params);

        return $unit;
    }

    public function delete(int $id): void
    {
        $user = $this->model->findOrFail($id);
        $user->delete();
    }
}
