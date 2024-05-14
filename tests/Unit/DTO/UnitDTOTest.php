<?php

namespace Tests\Unit\DTO;

use App\DTO\Unit\UnitDTO;
use stdClass;

beforeEach(function () {
    $this->paramsDTO = new stdClass();
    $this->paramsDTO->id = fake('pt_BR')->numberBetween(1);
    $this->paramsDTO->description = fake('pt_BR')->text(150);
    $this->paramsDTO->acronym = fake('pt_BR')->text(50);
    $this->paramsDTO->created_at = fake('pt_BR')->date();
    $this->paramsDTO->updated_at = fake('pt_BR')->date();
});

describe('Create class name UnitDTO', function () {
    it('UnitDTOTest must have id, description, acronym, created_at and updated_at', function () {
        $unitDTO = new UnitDTO(...(array) $this->paramsDTO);

        expect($unitDTO)->toHaveProperty('id');
        expect($unitDTO)->toHaveProperty('description');
        expect($unitDTO)->toHaveProperty('acronym');
        expect($unitDTO)->toHaveProperty('created_at');
        expect($unitDTO)->toHaveProperty('updated_at');

        expect($unitDTO->id)->toBe($this->paramsDTO->id);
        expect($unitDTO->description)->toBe($this->paramsDTO->description);
        expect($unitDTO->acronym)->toBe($this->paramsDTO->acronym);
        expect($unitDTO->created_at)->toBe($this->paramsDTO->created_at);
        expect($unitDTO->updated_at)->toBe($this->paramsDTO->updated_at);

        expect($unitDTO->id)->toBeInt();
        expect($unitDTO->description)->toBeString();
        expect($unitDTO->acronym)->toBeString();
        expect($unitDTO->created_at)->toBeString();
        expect($unitDTO->updated_at)->toBeString();
    });
});
