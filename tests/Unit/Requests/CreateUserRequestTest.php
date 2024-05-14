<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\User\CreateUserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

describe('CreateUserRequest', function () {
    beforeEach(function () {
        $this->rules = (new CreateUserRequest())->rules();
        $this->messages = (new CreateUserRequest())->messages();
        $this->role = DB::table('roles')->first();
    });

    it('must return the authorization', function () {
        $request = new CreateUserRequest();
        expect($request->authorize())->toBeTrue();
    });

    it('should pass without errors', function () {
        $validator = Validator::make([
            'cpf' => preg_replace('/\D/', '', fake('pt_BR')->cpf()),
            'name' => fake('pt_BR')->name(),
            'email' => fake('pt_BR')->email(),
            'password' => fake('pt_BR')->password(10),
            'active' => fake('pt_BR')->randomElement([0, 1]),
            'send_random_password' => true,
            'role_id' => $this->role->id,
        ], $this->rules, $this->messages);

        expect($validator->fails())->toBeFalse();
    });

    it('validates cpf field correctly for invalid format', function () {
        $validator = Validator::make([
            'cpf' => '00000000000',
            'name' => fake('pt_BR')->name(),
            'email' => fake('pt_BR')->email(),
            'password' => fake('pt_BR')->password(10),
            'active' => fake('pt_BR')->randomElement([0, 1]),
            'send_random_password' => true,
            'role_id' => $this->role->id,
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('cpf'))->toBe('O cpf inserido não é um cpf válido.');
    });

    it('validates email field correctly for invalid format', function () {
        $validator = Validator::make([
            'cpf' => '00000000000',
            'name' => fake('pt_BR')->name(),
            'email' => fake('pt_BR')->text(),
            'password' => fake('pt_BR')->password(10),
            'active' => fake('pt_BR')->randomElement([0, 1]),
            'send_random_password' => true,
            'role_id' => $this->role->id,
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('email'))->toBe('O email inserido não é válido.');
    });

    it('should return a message stating that the required fields have not been filled in', function () {
        $validator = Validator::make([
            'cpf' => '00000000000',
            'name' => null,
            'email' => null,
            'password' => fake('pt_BR')->password(10),
            'active' => null,
            'send_random_password' => true,
            'role_id' => null,
        ], $this->rules, $this->messages);

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('name'))->toBe('O campo name é obrigatório.');
        expect($validator->errors()->first('email'))->toBe('O campo email é obrigatório.');
        expect($validator->errors()->first('active'))->toBe('O campo active é obrigatório.');
        expect($validator->errors()->first('role_id'))->toBe('O campo role id é obrigatório.');
    });
})->group('request');
