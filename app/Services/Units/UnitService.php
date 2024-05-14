<?php

namespace App\Services\Units;

use App\DTO\Paginate\PaginateDataDTO;
use App\DTO\Paginate\PaginateParamsDTO;
use App\DTO\Unit\CreateUnitDTO;
use App\DTO\Unit\UnitDTO;
use App\DTO\Unit\UpdateUnitDTO;
use App\Repositories\Contracts\UnitRepositoryInterface;

class UnitService
{
    public function __construct(
        private UnitRepositoryInterface $repository
    ) {
    }

    public function index(PaginateParamsDTO $params): PaginateDataDTO
    {
        $units = $this->repository->list($params->toArray());

        return new PaginateDataDTO(...collect($units)->toArray());
    }

    public function create(CreateUnitDTO $createUnitDto): UnitDTO
    {
        $unit = $this->repository->create($createUnitDto->toArray());

        return new UnitDTO(
            ...$unit->toArray()
        );
    }

    public function getById(int $id): UnitDTO
    {
        $unit = $this->repository->getById($id);

        return new UnitDTO(...$unit->toArray());
    }

    public function update(int $id, UpdateUnitDTO $updateUnitDTO): UnitDTO
    {
        $unit = $this->repository->update($id, $updateUnitDTO->toArray());

        return new UnitDTO(...$unit->toArray());
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}
