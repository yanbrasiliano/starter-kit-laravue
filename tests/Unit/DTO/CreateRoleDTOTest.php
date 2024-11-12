<?php

namespace Tests\Unit\DTO;

use App\DTO\Role\CreateRoleDTO;
use stdClass;

beforeEach(function () {
    $this->paramsDTO = new stdClass();
    $this->paramsDTO->name = fake('pt_BR')->name();
    $this->paramsDTO->description = fake('pt_BR')->text();
    $this->paramsDTO->permissions = [[]];
});

describe('Create class name CreateRoleDTO', function () {
    it('CreateRoleDTOTest must have name, description and permissions', function () {
        $roleDTO = new CreateRoleDTO(...(array) $this->paramsDTO);

        expect($roleDTO)->toHaveProperty('name');
        expect($roleDTO)->toHaveProperty('description');
        expect($roleDTO)->toHaveProperty('permissions');

        expect($roleDTO->name)->toBe($this->paramsDTO->name);
        expect($roleDTO->description)->toBe($this->paramsDTO->description);
        expect($roleDTO->permissions)->toBe($this->paramsDTO->permissions);

        expect($roleDTO->name)->toBeString();
        expect($roleDTO->description)->toBeString();
        expect($roleDTO->permissions)->toBeArray();
    });
});
