<?php

namespace Tests\Unit\Requests;

use App\Enums\RolesEnum;
use App\Http\Requests\User\RegisterExternalUserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

describe('RegisterExternalUserRequest', function () {
    beforeEach(function () {
        $this->rules = (new RegisterExternalUserRequest())->rules();
        $this->messages = (new RegisterExternalUserRequest())->messages();
        $this->user = DB::table('users')->first();
    });

    it('must return the authorization', function () {
        $request = new RegisterExternalUserRequest();
        expect($request->authorize())->toBeTrue();
    });

    it('should pass without errors', function () {
        $password = fake('pt_BR')->password(10);
        $validator = Validator::make([
            'cpf' => preg_replace('/\D/', '', fake('pt_BR')->cpf()),
            'name' => fake('pt_BR')->name(),
            'email' => fake('pt_BR')->email(),
            'password' => $password,
            'password_confirmation' => $password,
            'role' => RolesEnum::REVIEWER->value,
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeFalse();
    });

    it('validates name field correctly for invalid type', function () {
        $password = fake('pt_BR')->password(10);
        $validator = Validator::make([
            'cpf' => preg_replace('/\D/', '', fake('pt_BR')->cpf()),
            'name' => 0000,
            'email' => fake('pt_BR')->email(),
            'password' => $password,
            'password_confirmation' => $password,
            'role' => RolesEnum::REVIEWER->value,
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('name'))->toBe('O campo nome deve ser string.');
    });

    it('validates cpf field correctly for invalid format', function () {
        $password = fake('pt_BR')->password(10);
        $validator = Validator::make([
            'cpf' => '00000000000',
            'name' => fake('pt_BR')->name(),
            'email' => fake('pt_BR')->email(),
            'password' => $password,
            'password_confirmation' => $password,
            'role' => RolesEnum::REVIEWER->value,
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('cpf'))->toBe('O cpf inserido não é um cpf válido.');
    });

    it('validates email field correctly for invalid format', function () {
        $password = fake('pt_BR')->password(10);
        $validator = Validator::make([
            'cpf' => preg_replace('/\D/', '', fake('pt_BR')->cpf()),
            'name' => fake('pt_BR')->name(),
            'email' => fake('pt_BR')->text(),
            'password' => $password,
            'password_confirmation' => $password,
            'role' => RolesEnum::REVIEWER->value,
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('email'))->toBe('O email inserido não é válido.');
    });

    it('validates that the profile option is valid', function () {
        $password = fake('pt_BR')->password(10);
        $validator = Validator::make([
            'cpf' => preg_replace('/\D/', '', fake('pt_BR')->cpf()),
            'name' => fake('pt_BR')->name(),
            'email' => fake('pt_BR')->text(),
            'password' => $password,
            'password_confirmation' => $password,
            'role' => 2,
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('role'))->toBe('O perfil selecionado é inválido.');
    });

    it('should return a message stating that the required fields have not been filled in', function () {
        $validator = Validator::make([
            'cpf' => null,
            'name' => null,
            'email' => null,
            'password' => null,
            'password_confirmation' => null,
            'role' => null,
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('cpf'))->toBe('O campo CPF é obrigatório.');
        expect($validator->errors()->first('name'))->toBe('O campo nome é obrigatório.');
        expect($validator->errors()->first('email'))->toBe('O campo email é obrigatório.');
        expect($validator->errors()->first('password'))->toBe('O campo senha é obrigatório.');
        expect($validator->errors()->first('role'))->toBe('O campo perfil é obrigatório.');
    });
})->group('request');
