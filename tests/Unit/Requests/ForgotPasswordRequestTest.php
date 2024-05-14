<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\Password\ForgotPasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

describe('ForgotPasswordRequestTest', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
        $this->rules = (new ForgotPasswordRequest())->rules();
        $this->messages = (new ForgotPasswordRequest())->messages();
    });

    it('should return true for authorization', function () {
        $request = new ForgotPasswordRequest();
        expect($request->authorize())->toBeTrue();
    })->group('request');

    it('should return a message stating that the email cannot be null', function () {
        $validator = Validator::make(['email' => null], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('email'))->toBe('O campo e-mail é obrigatório.');
    })->group('request');

    it('should return that the email field has an invalid format', function () {
        $validator = Validator::make(['email' => 'aaaaaa'], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('email'))->toBe('O campo e-mail deve ser um endereço de e-mail válido.');
    })->group('request');

    it('should return that the email entered has not yet been registered', function () {
        $validator = Validator::make(['email' => fake('pt_BR')->email()], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('email'))->toBe('Nenhum cadastro encontrado com o e-mail informado.');
    })->group('request');

    it('must pass validations without errors', function () {
        $validator = Validator::make(['email' => $this->user->email], $this->rules, $this->messages);
        expect($validator->fails())->toBeFalse();
    })->group('request');
});
