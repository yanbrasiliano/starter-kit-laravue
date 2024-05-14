<?php

namespace Tests\ThematicArea\DTO;

use App\DTO\ThematicArea\UpdateThematicAreaDTO;
use stdClass;

beforeEach(function () {
    $this->paramsDTO = new stdClass();
    $this->paramsDTO->description = fake('pt_BR')->name();
});

describe('Create class name UpdateThematicAreaDTO', function () {
    it('UpdateThematicAreaDTOTest must have description', function () {
        $updateThematicAreaDTO = new UpdateThematicAreaDTO(...(array) $this->paramsDTO);

        expect($updateThematicAreaDTO)->toHaveProperty('description');
        expect($updateThematicAreaDTO->description)->toBe($this->paramsDTO->description);
        expect($updateThematicAreaDTO->description)->toBeString();
    });
});
