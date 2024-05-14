<?php

namespace Tests\Unit\DTO;

use App\DTO\User\RegisterExternalUserDTO;
use stdClass;

beforeEach(function () {
    $this->paramsDTO = new stdClass();
    $this->paramsDTO->name = fake('pt_BR')->name();
    $this->paramsDTO->email = fake('pt_BR')->email();
    $this->paramsDTO->cpf = preg_replace('/\D/', '', fake('pt_BR')->cpf());
    $this->paramsDTO->role = fake('pt_BR')->text(5);
    $this->paramsDTO->password = fake('pt_BR')->password(8);
    $this->paramsDTO->password_confirmation = fake('pt_BR')->password(8);
});

describe('Create class name RegisterExternalUserDTOTest', function () {
    it('RegisterExternalUserDTOTest must have name, email, cpf, password and role', function () {
        $registerExternalUserDTO = new RegisterExternalUserDTO(...(array) $this->paramsDTO);

        expect($registerExternalUserDTO)->toHaveProperty('name');
        expect($registerExternalUserDTO)->toHaveProperty('email');
        expect($registerExternalUserDTO)->toHaveProperty('cpf');
        expect($registerExternalUserDTO)->toHaveProperty('role');
        expect($registerExternalUserDTO)->toHaveProperty('password');

        expect($registerExternalUserDTO->name)->toBe($this->paramsDTO->name);
        expect($registerExternalUserDTO->email)->toBe($this->paramsDTO->email);
        expect($registerExternalUserDTO->cpf)->toBe($this->paramsDTO->cpf);
        expect($registerExternalUserDTO->role)->toBe($this->paramsDTO->role);
        expect($registerExternalUserDTO->password)->toBe($this->paramsDTO->password);

        expect($registerExternalUserDTO->name)->toBeString();
        expect($registerExternalUserDTO->email)->toBeString();
        expect($registerExternalUserDTO->cpf)->toBeString();
        expect($registerExternalUserDTO->role)->toBeString();
        expect($registerExternalUserDTO->password)->toBeString();
    });
});
