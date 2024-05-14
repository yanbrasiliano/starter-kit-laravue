<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Validator;

describe('LoginRequest', function () {
    beforeEach(function () {
        $this->rules = (new LoginRequest())->rules();
        $this->messages = (new LoginRequest())->messages();
    });

    it('should return true for authorization', function () {
        $request = new LoginRequest();
        expect($request->authorize())->toBeTrue();
    })->group('request');

    it('validates email field correctly for null value', function () {
        $validator = Validator::make(['email' => null, 'password' => 'password'], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('email'))->toBe('O campo e-mail é obrigatório.');
    })->group('request');

    it('validates email field correctly for invalid format', function () {
        $validator = Validator::make(['email' => 'not-a-valid-email', 'password' => 'password'], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('email'))->toBe('O campo e-mail deve ser um endereço de e-mail válido.');
    })->group('request');

    it('validates password field correctly for null value', function () {
        $validator = Validator::make(['email' => 'user@example.com', 'password' => null], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('password'))->toBe('O campo senha é obrigatório.');
    })->group('request');

    it('validates password field correctly for non-string value', function () {
        $validator = Validator::make(['email' => 'user@example.com', 'password' => 123], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('password'))->toBe('O campo senha deve ser uma string.');
    })->group('request');

    it('passes validation for correct values', function () {
        $validator = Validator::make(['email' => 'user@example.com', 'password' => 'password'], $this->rules, $this->messages);
        expect($validator->fails())->toBeFalse();
    })->group('request');
});
