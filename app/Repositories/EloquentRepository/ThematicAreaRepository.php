<?php

namespace App\Repositories\EloquentRepository;

use App\DTO\Paginate\PaginateParamsDTO;
use App\DTO\ThematicArea\CreateThematicAreaDTO;
use App\DTO\ThematicArea\UpdateThematicAreaDTO;
use App\Models\ThematicArea;
use App\Repositories\AbstractRepository;
use App\Repositories\Contracts\ThematicAreaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

class ThematicAreaRepository extends AbstractRepository implements ThematicAreaRepositoryInterface
{
    private ThematicArea $thematicArea;

    public function __construct(ThematicArea $thematicArea)
    {
        $this->thematicArea = $thematicArea;
    }

    public function list(PaginateParamsDTO $paramsDTO): LengthAwarePaginator
    {
        $query = $this->thematicArea->query();
        $query->when($paramsDTO->search, function () use ($paramsDTO, $query) {
            $query->where('description', 'ilike', "%{$paramsDTO->search}%");
        })->when(isset($paramsDTO->order), function () use ($paramsDTO, $query) {
            $column = $paramsDTO->column ?? 'id';
            $query->orderBy($column, $paramsDTO->order);
        });

        return $query->paginate($paramsDTO->limit ?? 10);
    }

    public function create(CreateThematicAreaDTO $thematicAreaDTO): Model|ThematicArea
    {
        DB::beginTransaction();
        try {
            $thematicArea = $this->thematicArea->create([
                'description' => $thematicAreaDTO->description,
            ]);
            DB::commit();

            return $thematicArea;
        } catch (Throwable $thow) {
            DB::rollBack();
            throw $thow;
        }
    }

    public function getById(int $id): Model|ThematicArea
    {
        return $this->thematicArea->findOrFail($id);
    }

    public function update(int $id, UpdateThematicAreaDTO $thematicAreaDTO): Model|ThematicArea
    {
        DB::beginTransaction();
        try {
            $thematicArea = $this->thematicArea->findOrFail($id);

            $thematicArea->update([
                'description' => $thematicAreaDTO->description,
            ]);

            DB::commit();

            return $thematicArea;
        } catch (Throwable $thow) {
            DB::rollBack();
            throw $thow;
        }
    }

    public function delete(int $id): void
    {
        $thematicArea = $this->thematicArea->findOrFail($id);
        $thematicArea->delete();
    }
}
