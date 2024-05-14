<?php

namespace Tests\Unit\DTO;

use App\DTO\User\CreateUserDTO;
use Illuminate\Support\Facades\DB;
use stdClass;

beforeEach(function () {
    $this->paramsDTO = new stdClass();
    $this->paramsDTO->name = fake('pt_BR')->name();
    $this->paramsDTO->email = fake('pt_BR')->email();
    $this->paramsDTO->role_id = DB::table('roles')->first()->id;
    $this->paramsDTO->cpf = preg_replace('/\D/', '', fake('pt_BR')->cpf());
    $this->paramsDTO->password = fake('pt_BR')->password();
    $this->paramsDTO->active = fake('pt_BR')->randomElement([0, 1]);
    $this->paramsDTO->send_random_password = fake('pt_BR')->randomElement([0, 1]);
});

describe('Create class name CreateUserDTO', function () {
    it('CreateUserDTO must have name, email, cpf, active, password, role_id and send_random_password', function () {
        $createUserDTO = new CreateUserDTO(...(array) $this->paramsDTO);

        expect($createUserDTO)->toHaveProperty('name');
        expect($createUserDTO)->toHaveProperty('email');
        expect($createUserDTO)->toHaveProperty('role_id');
        expect($createUserDTO)->toHaveProperty('cpf');
        expect($createUserDTO)->toHaveProperty('password');
        expect($createUserDTO)->toHaveProperty('active');
        expect($createUserDTO)->toHaveProperty('send_random_password');

        expect($createUserDTO->name)->toBe($this->paramsDTO->name);
        expect($createUserDTO->email)->toBe($this->paramsDTO->email);
        expect($createUserDTO->role_id)->toBe($this->paramsDTO->role_id);
        expect($createUserDTO->cpf)->toBe($this->paramsDTO->cpf);
        expect($createUserDTO->password)->toBe($this->paramsDTO->password);
        expect($createUserDTO->active)->toBe($this->paramsDTO->active);
        expect($createUserDTO->send_random_password)->toBe($this->paramsDTO->send_random_password);

        expect($createUserDTO->name)->toBeString();
        expect($createUserDTO->email)->toBeString();
        expect($createUserDTO->role_id)->toBeInt();
        expect($createUserDTO->cpf)->toBeString();
        expect($createUserDTO->password)->toBeString();
        expect($createUserDTO->active)->toBeInt();
        expect($createUserDTO->send_random_password)->toBeInt();
    });
});
