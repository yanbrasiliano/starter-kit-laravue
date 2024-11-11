<?php

namespace Tests\Unit\DTO;

use App\DTO\User\UserDTO;
use stdClass;

beforeEach(function () {
    $this->paramsDTO = new stdClass();
    $this->paramsDTO->id = fake('pt_BR')->randomNumber();
    $this->paramsDTO->name = fake('pt_BR')->name();
    $this->paramsDTO->email = fake('pt_BR')->email();
    $this->paramsDTO->cpf = fake('pt_BR')->cpf();
    $this->paramsDTO->active = fake('pt_BR')->randomElement([0, 1]);
    $this->paramsDTO->email_verified_at = fake('pt_BR')->date();
    $this->paramsDTO->created_at = fake('pt_BR')->date();
    $this->paramsDTO->updated_at = fake('pt_BR')->date();
    $this->paramsDTO->roles = [];
});

describe('Create class name UserDTO', function () {
    it('UserDTO must have id, name, email, cpf, active, email_verified_at, created_at, updated_at and roles', function () {
        $userDTO = new UserDTO(...(array) $this->paramsDTO);

        expect($userDTO)->toHaveProperty('id');
        expect($userDTO)->toHaveProperty('name');
        expect($userDTO)->toHaveProperty('email');
        expect($userDTO)->toHaveProperty('cpf');
        expect($userDTO)->toHaveProperty('active');
        expect($userDTO)->toHaveProperty('email_verified_at');
        expect($userDTO)->toHaveProperty('created_at');
        expect($userDTO)->toHaveProperty('updated_at');
        expect($userDTO)->toHaveProperty('roles');

        expect($userDTO->id)->toBe($this->paramsDTO->id);
        expect($userDTO->name)->toBe($this->paramsDTO->name);
        expect($userDTO->email)->toBe($this->paramsDTO->email);
        expect($userDTO->cpf)->toBe($this->paramsDTO->cpf);
        expect($userDTO->active)->toBe($this->paramsDTO->active);
        expect($userDTO->email_verified_at)->toBe($this->paramsDTO->email_verified_at);
        expect($userDTO->created_at)->toBe($this->paramsDTO->created_at);
        expect($userDTO->updated_at)->toBe($this->paramsDTO->updated_at);
        expect($userDTO->roles)->toBe($this->paramsDTO->roles);

        expect($userDTO->id)->toBeInt();
        expect($userDTO->name)->toBeString();
        expect($userDTO->email)->toBeString();
        expect($userDTO->cpf)->toBeString();
        expect($userDTO->active)->toBeInt();
        expect($userDTO->email_verified_at)->toBeString();
        expect($userDTO->created_at)->toBeString();
        expect($userDTO->updated_at)->toBeString();
        expect($userDTO->roles)->toBeArray();
    });
});
