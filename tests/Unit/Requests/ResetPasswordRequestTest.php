<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\Password\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

describe('ResetPasswordRequestTest', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
        $this->rules = (new ResetPasswordRequest())->rules();
        $this->messages = (new ResetPasswordRequest())->messages();
    });

    it('should return true for authorization', function () {
        $request = new ResetPasswordRequest();
        expect($request->authorize())->toBeTrue();
    })->group('request');

    it('should return that the password field is required', function () {
        $validator = Validator::make([
            'password' => null,
            'password_confirmation' => null,
            'email' => $this->user->email,
            'token' => fake('pt_BR')->text(10),
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('password'))->toBe('O campo senha é obrigatório.');
    })->group('request');

    it('should return that the minimum character length in the password field has not been reached', function () {
        $password = 'AAA';
        $validator = Validator::make([
            'password' => $password,
            'password_confirmation' => $password,
            'email' => $this->user->email,
            'token' => fake('pt_BR')->text(10),
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('password'))->toBe('O campo senha deve conter no minimo 8 caracteres.');
    })->group('request');

    it('should return that the passwords dont match', function () {
        $validator = Validator::make([
            'password' => fake('pt_BR')->password(9),
            'password_confirmed' => fake('pt_BR')->password(9),
            'email' => $this->user->email,
            'token' => fake('pt_BR')->text(10),
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('password'))->toBe('As senhas não conferem.');
    })->group('request');

    it('must pass validations without errors', function () {
        $password = fake('pt_BR')->password(10);
        $validator = Validator::make([
            'password' => $password,
            'password_confirmation' => $password,
            'email' => $this->user->email,
            'token' => fake('pt_BR')->text(10),
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeFalse();
    })->group('request');

    it('should return that the email field is required', function () {
        $validator = Validator::make([
            'password' => fake('pt_BR')->password(9),
            'password_confirmed' => fake('pt_BR')->password(9),
            'email' => null,
            'token' => fake('pt_BR')->text(10),
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('email'))->toBe('O campo e-mail é obrigatório.');
    })->group('request');

    it('should return that the email has not yet been registered', function () {
        $validator = Validator::make([
            'password' => fake('pt_BR')->password(9),
            'password_confirmed' => fake('pt_BR')->password(9),
            'email' => fake('pt_BR')->text(),
            'token' => fake('pt_BR')->text(10),
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('email'))->toBe('O campo e-mail deve ser um endereço de e-mail válido.');
    })->group('request');

    it('should return that the email has an invalid format', function () {
        $validator = Validator::make([
            'password' => fake('pt_BR')->password(9),
            'password_confirmed' => fake('pt_BR')->password(9),
            'email' => fake('pt_BR')->email(),
            'token' => fake('pt_BR')->text(10),
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('email'))->toBe('Nenhum cadastro encontrado com o e-mail informado.');
    })->group('request');

    it('should return that the token field is required', function () {
        $validator = Validator::make([
            'password' => fake('pt_BR')->password(9),
            'password_confirmed' => fake('pt_BR')->password(9),
            'email' => $this->user->email,
            'token' => null,
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('token'))->toBe('O token não foi fornecido.');
    })->group('request');

    it('should return that the token has an invalid format', function () {
        $validator = Validator::make([
            'password' => fake('pt_BR')->password(9),
            'password_confirmed' => fake('pt_BR')->password(9),
            'email' => $this->user->email,
            'token' => 10000,
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('token'))->toBe('O token contém o tipo inválido.');
    })->group('request');
});
