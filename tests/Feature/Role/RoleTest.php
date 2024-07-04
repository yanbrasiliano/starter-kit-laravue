<?php

namespace Tests\Feature\Authentication;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Http\Response;
use Spatie\Permission\Models\{Permission, Role};

beforeEach(function () {
    $this->userAuth = User::factory()->create();
    $roleAdminId = Role::where('slug', RolesEnum::ADMINISTRATOR->value)->first()->id;
    $this->userAuth->assignRole([$roleAdminId]);
    $this->roles = Role::all();
});

describe('RoleTest', function () {
    describe('Listing Roles', function () {
        it('should return a 200 status code and proper JSON structure', function () {
            $this->actingAs($this->userAuth);
            $response = $this->get(route('roles.list'));
            $response->assertStatus(Response::HTTP_OK);
            $response->assertJsonStructure([
                'data',
                'links',
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'current_page',
                    'links',
                    'path',
                    'per_page',
                    'to',
                    'total',
                ],
            ]);
        });
    });

    describe('Querying Role Data', function () {
        it('should return a 200 status code and proper JSON structure for valid unit ID', function () {
            $this->actingAs($this->userAuth);
            $response = $this->get(route('roles.view', ['id' => $this->roles->first()->id]));

            $response->assertStatus(Response::HTTP_OK);
            $response->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'shortDescription',
                    'createdAt',
                    'permissions',
                ],
            ]);
        });

        it('should return a 404 status code for invalid unit ID', function () {
            $this->actingAs($this->userAuth);
            $response = $this->get(route('roles.view', ['id' => 100000]));
            $response->assertStatus(Response::HTTP_NOT_FOUND);
        });
    });

    describe('Registering Roles', function () {
        it('should return a 200 status code and proper JSON structure for valid unit data', function () {
            $this->actingAs($this->userAuth);
            $response = $this->post(route('roles.create'), [
                'name' => fake('pt_BR')->text(30),
                'description' => fake('pt_BR')->text(50),
                'permissions' => [
                    Permission::all()->first()->id,
                ],
            ]);
            $response->assertStatus(Response::HTTP_OK);
            $response->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'shortDescription',
                    'createdAt',
                    'permissions',
                ],
            ]);
        });
    });

    describe('Updating Role', function () {
        it('should return a 200 status code and proper JSON structure for valid role ID and data', function () {
            $this->actingAs($this->userAuth);
            $response = $this->put(route('roles.edit', ['id' => $this->roles->first()->id]), [
                'name' => fake('pt_BR')->text(30),
                'description' => fake('pt_BR')->text(50),
                'permissions' => [
                    Permission::all()->first()->id,
                ],
            ]);
            $response->assertStatus(Response::HTTP_OK);
            $response->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'shortDescription',
                    'createdAt',
                    'permissions',
                ],
            ]);
        });

        it('should return a 404 status code for invalid role ID', function () {
            $this->actingAs($this->userAuth);
            $response = $this->put(route('roles.edit', ['id' => 1000000]), [
                'name' => fake('pt_BR')->text(30),
                'description' => fake('pt_BR')->text(50),
                'permissions' => [
                    Permission::all()->first()->id,
                ],
            ]);
            $response->assertStatus(Response::HTTP_NOT_FOUND);
        });
    });

    describe('Deleting Roles', function () {
        it('should return a 204 status code for valid unit ID', function () {
            $this->actingAs($this->userAuth);
            $response = $this->delete(route('roles.delete', ['id' => $this->roles->first()->id]));
            $response->assertStatus(Response::HTTP_NO_CONTENT);
        });

        it('should return a 404 status code for invalid unit ID', function () {
            $this->actingAs($this->userAuth);
            $response = $this->delete(route('roles.delete', ['id' => 100000000]));
            $response->assertStatus(Response::HTTP_NOT_FOUND);
        });
    });

    describe('List all Roles', function () {
        it('should return a 200 status code and proper JSON structure', function () {
            $this->actingAs($this->userAuth);
            $response = $this->get(route('roles.listAll'));
            $response->assertStatus(Response::HTTP_OK);
            $response->assertJsonStructure([
                'data',
            ]);
        });
    });
})->group('RoleTest');
