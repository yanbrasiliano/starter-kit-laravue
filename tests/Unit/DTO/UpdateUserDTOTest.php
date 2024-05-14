<?php

namespace Tests\Unit\DTO;

use App\DTO\User\UpdateUserDTO;
use Illuminate\Support\Facades\DB;
use stdClass;

beforeEach(function () {
    $this->paramsDTO = new stdClass();
    $this->paramsDTO->name = fake('pt_BR')->name();
    $this->paramsDTO->email = fake('pt_BR')->email();
    $this->paramsDTO->active = fake('pt_BR')->randomElement([0, 1]);
    $this->paramsDTO->cpf = preg_replace('/\D/', '', fake('pt_BR')->cpf());
    $this->paramsDTO->password = fake('pt_BR')->password();
    $this->paramsDTO->created_at = fake('pt_BR')->date();
    $this->paramsDTO->role_id = DB::table('roles')->first()->id;
    $this->paramsDTO->notify_status = fake('pt_BR')->randomElement([0, 1]);
});

describe('Create class name UpdateUserDTO', function () {
    it('UserDTO must have name, email, cpf, active, password, created_at, role_id and notify_status', function () {
        $updateUserDTO = new UpdateUserDTO(...(array) $this->paramsDTO);

        expect($updateUserDTO)->toHaveProperty('name');
        expect($updateUserDTO)->toHaveProperty('email');
        expect($updateUserDTO)->toHaveProperty('active');
        expect($updateUserDTO)->toHaveProperty('cpf');
        expect($updateUserDTO)->toHaveProperty('password');
        expect($updateUserDTO)->toHaveProperty('created_at');
        expect($updateUserDTO)->toHaveProperty('role_id');
        expect($updateUserDTO)->toHaveProperty('notify_status');

        expect($updateUserDTO->name)->toBe($this->paramsDTO->name);
        expect($updateUserDTO->email)->toBe($this->paramsDTO->email);
        expect($updateUserDTO->active)->toBe($this->paramsDTO->active);
        expect($updateUserDTO->cpf)->toBe($this->paramsDTO->cpf);
        expect($updateUserDTO->password)->toBe($this->paramsDTO->password);
        expect($updateUserDTO->created_at)->toBe($this->paramsDTO->created_at);
        expect($updateUserDTO->role_id)->toBe($this->paramsDTO->role_id);
        expect($updateUserDTO->notify_status)->toBe($this->paramsDTO->notify_status);

        expect($updateUserDTO->name)->toBeString();
        expect($updateUserDTO->email)->toBeString();
        expect($updateUserDTO->active)->toBeInt();
        expect($updateUserDTO->cpf)->toBeString();
        expect($updateUserDTO->password)->toBeString();
        expect($updateUserDTO->created_at)->toBeString();
        expect($updateUserDTO->role_id)->toBeInt();
        expect($updateUserDTO->notify_status)->toBeInt();
    });
});
