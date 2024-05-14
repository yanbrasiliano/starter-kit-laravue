<?php

namespace Tests\Feature\Authentication;

use App\Enums\RolesEnum;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->userAuth = User::factory()->create();
    $roleAdminId = Role::where('slug', RolesEnum::ADMINISTRATOR->value)->first()->id;
    $this->userAuth->assignRole([$roleAdminId]);
    $this->units = Unit::factory(20)->create();
    $this->unit = Unit::factory()->create();
});

describe('UnitTest', function () {
    describe('Listing Units', function () {
        it('should return a 200 status code and proper JSON structure', function () {
            $this->actingAs($this->userAuth);
            $response = $this->get(route('units.list'));
            $response->assertStatus(Response::HTTP_OK);
            $response->assertJsonStructure([
                'current_page',
                'data',
                'first_page_url',
                'from',
                'last_page',
                'links',
                'next_page_url',
                'path',
                'last_page_url',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ]);
        });
    });

    describe('Querying Unit Data', function () {
        it('should return a 200 status code and proper JSON structure for valid unit ID', function () {
            $this->actingAs($this->userAuth);
            $response = $this->get(route('units.view', ['id' => $this->unit->id]));
            $response->assertStatus(Response::HTTP_OK);
            $response->assertJsonStructure([
                'data' => [
                    'id',
                    'description',
                    'acronym',
                ],
            ]);
        });

        it('should return a 404 status code for invalid unit ID', function () {
            $this->actingAs($this->userAuth);
            $response = $this->get(route('units.view', ['id' => 100000]));
            $response->assertStatus(Response::HTTP_NOT_FOUND);
        });
    });

    describe('Registering Units', function () {
        it('should return a 200 status code and proper JSON structure for valid unit data', function () {
            $this->actingAs($this->userAuth);
            $response = $this->post(route('units.create'), [
                'description' => fake('pt_BR')->text(150),
                'acronym' => fake('pt_BR')->text(50),
            ]);
            $response->assertStatus(Response::HTTP_OK);
            $response->assertJsonStructure([
                'data' => [
                    'id',
                    'description',
                    'acronym',
                    'created_at',
                    'updated_at',
                ],
            ]);
        });
    });

    describe('Updating Unit', function () {
        it('should return a 200 status code and proper JSON structure for valid unit ID and data', function () {
            $this->actingAs($this->userAuth);
            $response = $this->put(route('units.edit', ['id' => $this->unit->id]), [
                'description' => fake('pt_BR')->text(150),
                'acronym' => fake('pt_BR')->text(50),
            ]);
            $response->assertStatus(Response::HTTP_OK);
            $response->assertJsonStructure([
                'data' => [
                    'id',
                    'description',
                    'acronym',
                    'created_at',
                    'updated_at',
                ],
            ]);
        });

        it('should return a 404 status code for invalid unit ID', function () {
            $this->actingAs($this->userAuth);
            $response = $this->put(route('units.edit', ['id' => 1000000]), [
                'description' => fake('pt_BR')->text(150),
                'acronym' => fake('pt_BR')->text(50),
            ]);
            $response->assertStatus(Response::HTTP_NOT_FOUND);
        });
    });

    describe('Deleting Units', function () {
        it('should return a 204 status code for valid unit ID', function () {
            $this->actingAs($this->userAuth);
            $response = $this->delete(route('units.delete', ['id' => $this->unit->id]));
            $response->assertStatus(Response::HTTP_NO_CONTENT);
        });

        it('should return a 404 status code for invalid unit ID', function () {
            $this->actingAs($this->userAuth);
            $response = $this->delete(route('units.delete', ['id' => 100000000]));
            $response->assertStatus(Response::HTTP_NOT_FOUND);
        });
    });
})->group('UnitTest');
