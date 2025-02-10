<?php

namespace Tests\Feature\Authentication;

use App\Enums\RolesEnum;
use App\Models\User;
use Spatie\Permission\Models\{Permission, Role};
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->userAuth = User::factory()->create();
    $roleAdminId = Role::where('slug', RolesEnum::ADMINISTRATOR->value)->first()->id;
    $this->userAuth->assignRole([$roleAdminId]);
    $this->roles = Role::all();
    $this->invalidId = 100000;
});

describe('Role Tests', function () {
    it('should list and return a 200 status code and proper JSON structure', function () {
        $this->actingAs($this->userAuth);
        $this->get(route('roles.list'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
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

    it('should view one role and return a 200 status code and proper JSON structure when accessing a valid unit ID', function () {
        $this->actingAs($this->userAuth);
        $this->get(
            route(
                'roles.view',
                $this->roles->first()->id
            )
        )->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
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
        $response = $this->get(route('roles.view', $this->invalidId));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    });

    it('should create and return a 200 status code and proper JSON structure for valid unit data', function () {
        $this->actingAs($this->userAuth);
        $response = $this->post(route('roles.create'), [
            'name' => fake('pt_BR')->text(30),
            'description' => fake('pt_BR')->text(50),
            'permissions' => [
                Permission::all()->first()->id,
            ],
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
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

    it('should edit and return a 200 status code and proper JSON structure for valid role ID and data', function () {
        $this->actingAs($this->userAuth);

        $role = $this->roles->where('slug', RolesEnum::REVIEWER->value)->first();

        $this->put(route('roles.edit', $role->id), [
            'name' => fake('pt_BR')->text(30),
            'description' => fake('pt_BR')->text(50),
            'permissions' => [
                Permission::inRandomOrder()->first()->id,
            ],
        ])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
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

    it('should return a 404 status code for invalid role ID', function (): void {
        $this->actingAs($this->userAuth);
        $response = $this->put(route('roles.edit', $this->invalidId), [
            'name' => fake('pt_BR')->text(30),
            'description' => fake('pt_BR')->text(50),
            'permissions' => [
                Permission::all()->first()->id,
            ],
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    });

    it('should return a 204 status code for valid role ID', function () {
        $this->actingAs($this->userAuth);

        $role = $this->roles->last();
        $role->users()->each(function ($user) use ($role): void {
            $user->removeRole($role->name);
        });

        $this->delete(route('roles.delete', $role->id))
            ->assertStatus(Response::HTTP_NO_CONTENT);
    });

    it('should return 403 when trying to remove roles that have linked users', function () {
        $this->actingAs($this->userAuth);
        $role = $this->roles->first();
        $response = $this->delete(route('roles.delete', $role->id));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    });

    it('should return a 404 status code when trying to delete a invalid role ID', function () {
        $this->actingAs($this->userAuth);
        $response = $this->delete(route('roles.delete', $this->invalidId));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    });

})->group('roles');
