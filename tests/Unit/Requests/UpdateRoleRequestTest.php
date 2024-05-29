<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\Role\UpdateRoleRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

describe('UpdateRoleRequestTest', function () {
    beforeEach(function () {
        $this->rules = (new UpdateRoleRequest())->rules();
        $this->messages = (new UpdateRoleRequest())->messages();
        $this->role = DB::table('roles')->first();
    });

    it('must return the authorization', function () {
        $request = new UpdateRoleRequest();
        expect($request->authorize())->toBeTrue();
    });

    it('should pass without errors', function () {
        $validator = Validator::make([
            'name' => fake('pt_BR')->text(50),
            'description' => fake('pt_BR')->text(50),
            'permissions' => [
                Permission::all()->first()->id,
            ],
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeFalse();
    });

    it('should return that the fields are incorrectly formatted', function () {
        $validator = Validator::make([
            'name' => 000000000,
            'description' => 000000000,
            'permissions' => 000000000,
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('name'))->toBe('O name deve conter uma palavra.');
        expect($validator->errors()->first('permissions'))->toBe('O permissions deve ser uma lista');
    });

    it('should return a message stating that the required fields have not been filled in', function () {
        $validator = Validator::make([
            'name' => null,
            'description' => null,
            'permissions' => null,
        ], $this->rules, $this->messages);

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('name'))->toBe('O name é obrigatório.');
        expect($validator->errors()->first('permissions'))->toBe('O permissions deve ser uma lista');
    });

    it('should return that it has exceeded the character limit of the description field', function () {
        $validator = Validator::make([
            'name' => fake('pt_BR')->text(50),
            'description' => fake('pt_BR')->paragraph(90),
            'permissions' => [
                Permission::all()->first()->id,
            ],
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('description'))->toBe('A description inserida excede o limite de caracteres.');
    });

    it('should return that a role with the given name already exists', function () {
        $validator = Validator::make([
            'name' => $this->role->name,
            'description' => fake('pt_BR')->text(50),
            'permissions' => [
                Permission::all()->first()->id,
            ],
        ], $this->rules, $this->messages);
        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->first('name'))->toBe('O name inserido já está em uso.');
    });
});
