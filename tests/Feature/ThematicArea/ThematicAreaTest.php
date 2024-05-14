<?php

namespace Tests\Feature\Authentication;

use App\Enums\RolesEnum;
use App\Models\ThematicArea;
use App\Models\User;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->userAuth = User::factory()->create();
    $roleAdminId = Role::where('slug', RolesEnum::ADMINISTRATOR->value)->first()->id;
    $this->userAuth->assignRole([$roleAdminId]);
    $this->thematicAreas = ThematicArea::factory(20)->create();
    $this->thematicArea = ThematicArea::factory()->create();
});

describe('ThematicAreaTest', function () {
    describe('Listing ThematicAreas', function () {
        it('should return a 200 status code and proper JSON structure', function () {
            $this->actingAs($this->userAuth);
            $response = $this->get(route('thematic_areas.list'));
            $response->assertStatus(Response::HTTP_OK);
            $response->assertJsonStructure([
                'links',
                'data',
                'meta',
            ]);
        });
    });

    describe('Querying ThematicArea Data', function () {
        it('should return a 200 status code and proper JSON structure for valid thematic_area ID', function () {
            $this->actingAs($this->userAuth);
            $response = $this->get(route('thematic_areas.view', ['id' => $this->thematicArea->id]));
            $response->assertStatus(Response::HTTP_OK);
            $response->assertJsonStructure([
                'data' => [
                    'id',
                    'description',
                ],
            ]);
        });

        it('should return a 404 status code for invalid thematic_area ID', function () {
            $this->actingAs($this->userAuth);
            $response = $this->get(route('thematic_areas.view', ['id' => 100000]));
            $response->assertStatus(Response::HTTP_NOT_FOUND);
        });
    });

    describe('Registering ThematicAreas', function () {
        it('should return a 200 status code and proper JSON structure for valid thematic_area data', function () {
            $this->actingAs($this->userAuth);
            $response = $this->post(route('thematic_areas.create'), [
                'description' => fake('pt_BR')->text(150),
            ]);
            $response->assertStatus(Response::HTTP_OK);
            $response->assertJsonStructure([
                'data' => [
                    'id',
                    'description',
                ],
            ]);
        });
    });

    describe('Updating ThematicArea', function () {
        it('should return a 200 status code and proper JSON structure for valid thematic_area ID and data', function () {
            $this->actingAs($this->userAuth);
            $response = $this->put(route('thematic_areas.edit', ['id' => $this->thematicArea->id]), [
                'description' => fake('pt_BR')->text(150),
            ]);
            $response->assertStatus(Response::HTTP_OK);
            $response->assertJsonStructure([
                'data' => [
                    'id',
                    'description',
                ],
            ]);
        });

        it('should return a 404 status code for invalid thematic_area ID', function () {
            $this->actingAs($this->userAuth);
            $response = $this->put(route('thematic_areas.edit', ['id' => 1000000]), [
                'description' => fake('pt_BR')->text(150),
            ]);
            $response->assertStatus(Response::HTTP_NOT_FOUND);
        });
    });

    describe('Deleting ThematicAreas', function () {
        it('should return a 204 status code for valid thematic_area ID', function () {
            $this->actingAs($this->userAuth);
            $response = $this->delete(route('thematic_areas.delete', ['id' => $this->thematicArea->id]));
            $response->assertStatus(Response::HTTP_NO_CONTENT);
        });

        it('should return a 404 status code for invalid thematic_area ID', function () {
            $this->actingAs($this->userAuth);
            $response = $this->delete(route('thematic_areas.delete', ['id' => 100000000]));
            $response->assertStatus(Response::HTTP_NOT_FOUND);
        });
    });
})->group('ThematicAreaTest');
