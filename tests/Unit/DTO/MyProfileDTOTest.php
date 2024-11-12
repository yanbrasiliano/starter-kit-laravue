<?php

namespace Tests\Unit\DTO;

use App\DTO\Authenticate\MyProfileDTO;
use stdClass;

beforeEach(function () {
    $this->paramsDTO = new stdClass();
    $this->paramsDTO->name = fake('pt_BR')->name();
    $this->paramsDTO->email = fake('pt_BR')->email();
    $this->paramsDTO->permissions = [[
        'name' => 'test',
        'slug' => 'test',
    ]];
    $this->paramsDTO->roles = [[
        'id' => '1',
        'name' => 'test',
    ]];
});

describe('Create class name MyProfileDTOTest', function () {
    it('MyProfileDTOTest must have name, email, permissions and roles', function () {
        $myProfileDTO = new MyProfileDTO(...(array) $this->paramsDTO);

        expect($myProfileDTO)->toHaveProperty('name');
        expect($myProfileDTO)->toHaveProperty('email');
        expect($myProfileDTO)->toHaveProperty('permissions');
        expect($myProfileDTO)->toHaveProperty('roles');

        expect($myProfileDTO->name)->toBe($this->paramsDTO->name);
        expect($myProfileDTO->email)->toBe($this->paramsDTO->email);
        expect($myProfileDTO->permissions)->toBe($this->paramsDTO->permissions);
        expect($myProfileDTO->roles)->toBe($this->paramsDTO->roles);

        expect($myProfileDTO->name)->toBeString();
        expect($myProfileDTO->email)->toBeString();
        expect($myProfileDTO->permissions)->toBeArray();
        expect($myProfileDTO->roles)->toBeArray();
    });
});
