<?php

namespace Tests\ThematicArea\DTO;

use App\DTO\ThematicArea\ThematicAreaDTO;
use stdClass;

beforeEach(function () {
    $this->paramsDTO = new stdClass();
    $this->paramsDTO->id = fake('pt_BR')->numberBetween(1);
    $this->paramsDTO->description = fake('pt_BR')->text(150);
    $this->paramsDTO->created_at = fake('pt_BR')->date();
    $this->paramsDTO->updated_at = fake('pt_BR')->date();
});

describe('Create class name ThematicAreaDTO', function () {
    it('ThematicAreaDTOTest must have id, description, created_at and updated_at', function () {
        $thematicAreaDTO = new ThematicAreaDTO(...(array) $this->paramsDTO);

        expect($thematicAreaDTO)->toHaveProperty('id');
        expect($thematicAreaDTO)->toHaveProperty('description');
        expect($thematicAreaDTO)->toHaveProperty('created_at');
        expect($thematicAreaDTO)->toHaveProperty('updated_at');

        expect($thematicAreaDTO->id)->toBe($this->paramsDTO->id);
        expect($thematicAreaDTO->description)->toBe($this->paramsDTO->description);
        expect($thematicAreaDTO->created_at)->toBe($this->paramsDTO->created_at);
        expect($thematicAreaDTO->updated_at)->toBe($this->paramsDTO->updated_at);

        expect($thematicAreaDTO->id)->toBeInt();
        expect($thematicAreaDTO->description)->toBeString();
        expect($thematicAreaDTO->created_at)->toBeString();
        expect($thematicAreaDTO->updated_at)->toBeString();
    });
});
