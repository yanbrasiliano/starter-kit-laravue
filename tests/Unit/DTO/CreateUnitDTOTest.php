<?php

namespace Tests\Unit\DTO;

use App\DTO\Unit\CreateUnitDTO;
use stdClass;

beforeEach(function () {
    $this->paramsDTO = new stdClass();
    $this->paramsDTO->description = fake('pt_BR')->text(150);
    $this->paramsDTO->acronym = fake('pt_BR')->text(50);
});

describe('Create class name CreateUnitDTO', function () {
    it('CreateUnitDTOTest must have description and acronym', function () {
        $createUnitDTO = new CreateUnitDTO(...(array) $this->paramsDTO);

        expect($createUnitDTO)->toHaveProperty('description');
        expect($createUnitDTO)->toHaveProperty('acronym');

        expect($createUnitDTO->description)->toBe($this->paramsDTO->description);
        expect($createUnitDTO->acronym)->toBe($this->paramsDTO->acronym);

        expect($createUnitDTO->description)->toBeString();
        expect($createUnitDTO->acronym)->toBeString();
    });
});
