<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\Unit\CreateUnitRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

describe('CreateUnitRequestTest', function () {
    beforeEach(function () {
        $this->rules = (new CreateUnitRequest())->rules();
        $this->messages = (new CreateUnitRequest())->messages();
        $this->role = DB::table('units')->first();
    });

    it('must return the authorization', function () {
        $request = new CreateUnitRequest();
        expect($request->authorize())->toBeTrue();
    });

    it('should pass without errors', function () {
        $validator = Validator::make([
            'description' => fake('pt_BR')->text(50),
            'acronym' => fake('pt_BR')->text(50),
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeFalse();
    });

    it('validates description field correctly for invalid format', function () {
        $validator = Validator::make([
            'description' => 000000000,
            'acronym' => fake('pt_BR')->text(50),
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('description'))->toBe('O campo descrição deve ser string.');
    });

    it('validates acronym field correctly for invalid format', function () {
        $validator = Validator::make([
            'description' => fake('pt_BR')->text(50),
            'acronym' => 000000000,
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('acronym'))->toBe('O campo sigla deve ser string.');
    });

    it('should return a message stating that the required fields have not been filled in', function () {
        $validator = Validator::make([
            'description' => null,
            'acronym' => null,
        ], $this->rules, $this->messages);

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('description'))->toBe('O campo descrição é obrigatório.');
        expect($validator->errors()->first('acronym'))->toBe('O campo sigla é obrigatório.');
    });

    it('should return that the fields exceed the character limit', function () {
        $validator = Validator::make([
            'description' => fake('pt_BR')->paragraph(50),
            'acronym' => fake('pt_BR')->paragraph(10),
        ], $this->rules, $this->messages);

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('description'))->toBe('O campo descrição excede o limite de 150 caracteres.');
        expect($validator->errors()->first('acronym'))->toBe('O campo sigla excede o limite de 50 caracteres.');
    });
});
