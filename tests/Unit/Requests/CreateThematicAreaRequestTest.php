<?php

namespace Tests\ThematicArea\Requests;

use App\Http\Requests\ThematicArea\CreateThematicAreaRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

describe('CreateThematicAreaRequestTest', function () {
    beforeEach(function () {
        $this->rules = (new CreateThematicAreaRequest())->rules();
        $this->messages = (new CreateThematicAreaRequest())->messages();
        $this->thematic_area = DB::table('thematic_areas')->first();
    });

    it('must return the authorization', function () {
        $request = new CreateThematicAreaRequest();
        expect($request->authorize())->toBeTrue();
    });

    it('should pass without errors', function () {
        $validator = Validator::make([
            'description' => fake('pt_BR')->text(50),
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeFalse();
    });

    it('validates description field correctly for invalid format', function () {
        $validator = Validator::make([
            'description' => 000000000,
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('description'))->toBe('O campo descrição deve ser string.');
    });

    it('should return a message stating that the required fields have not been filled in', function () {
        $validator = Validator::make([
            'description' => null,
        ], $this->rules, $this->messages);

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('description'))->toBe('O campo descrição é obrigatório.');
    });

    it('should return that the fields exceed the character limit', function () {
        $validator = Validator::make([
            'description' => fake('pt_BR')->text(500),
        ], $this->rules, $this->messages);

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('description'))->toBe('O campo descrição excede o limite de 150 caracteres.');
    });
});
