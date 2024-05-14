<?php

namespace Tests\ThematicArea\DTO;

use App\DTO\ThematicArea\CreateThematicAreaDTO;
use stdClass;

beforeEach(function () {
    $this->paramsDTO = new stdClass();
    $this->paramsDTO->description = fake('pt_BR')->text(150);
});

describe('Create class name CreateThematicAreaDTO', function () {
    it('CreateThematicAreaDTOTest must have description', function () {
        $createThematicAreaDTO = new CreateThematicAreaDTO(...(array) $this->paramsDTO);

        expect($createThematicAreaDTO)->toHaveProperty('description');
        expect($createThematicAreaDTO->description)->toBe($this->paramsDTO->description);
        expect($createThematicAreaDTO->description)->toBeString();
    });
});
