<?php

namespace App\Services\ThematicArea;

use App\DTO\Paginate\PaginateParamsDTO;
use App\DTO\ThematicArea\CreateThematicAreaDTO;
use App\DTO\ThematicArea\ThematicAreaDTO;
use App\DTO\ThematicArea\UpdateThematicAreaDTO;
use App\Repositories\Contracts\ThematicAreaRepositoryInterface;
use Illuminate\Http\JsonResponse;

class ThematicAreaService
{
    public function __construct(
        private ThematicAreaRepositoryInterface $repository
    ) {
    }

    public function index(PaginateParamsDTO $params)
    {
        $thematicAreas = $this->repository->list($params);

        return $thematicAreas;
    }

    public function create(CreateThematicAreaDTO $thematicAreaDto): ThematicAreaDTO
    {
        $thematicArea = $this->repository->create($thematicAreaDto);

        return new ThematicAreaDTO(...$thematicArea->toArray());
    }

    public function getById(int $id): ThematicAreaDTO
    {
        $thematicArea = $this->repository->getById($id);

        return new ThematicAreaDTO(...$thematicArea->toArray());
    }

    public function update(int $id, UpdateThematicAreaDTO $thematicAreaDTO): ThematicAreaDTO
    {
        $thematicArea = $this->repository->update($id, $thematicAreaDTO);

        return new ThematicAreaDTO(...$thematicArea->toArray());
    }

    public function delete(int $id): JsonResponse
    {
        $this->repository->delete($id);

        return response()->json([], JsonResponse::HTTP_NO_CONTENT);
    }
}
