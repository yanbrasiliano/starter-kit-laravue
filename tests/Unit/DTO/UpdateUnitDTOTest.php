<?php

namespace Tests\Unit\DTO;

use App\DTO\Unit\UpdateUnitDTO;
use stdClass;

beforeEach(function () {
    $this->paramsDTO = new stdClass();
    $this->paramsDTO->description = fake('pt_BR')->name();
    $this->paramsDTO->acronym = fake('pt_BR')->email();
});

describe('Create class name UpdateUnitDTO', function () {
    it('UpdateUnitDTOTest must have description and acronym', function () {
        $updateUnitDTO = new UpdateUnitDTO(...(array) $this->paramsDTO);

        expect($updateUnitDTO)->toHaveProperty('description');
        expect($updateUnitDTO)->toHaveProperty('acronym');

        expect($updateUnitDTO->description)->toBe($this->paramsDTO->description);
        expect($updateUnitDTO->acronym)->toBe($this->paramsDTO->acronym);

        expect($updateUnitDTO->description)->toBeString();
        expect($updateUnitDTO->acronym)->toBeString();
    });
});
