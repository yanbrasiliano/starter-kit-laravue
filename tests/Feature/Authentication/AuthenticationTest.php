<?php

namespace Tests\Feature\Authentication;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->inactiveUser = User::factory()->create([
        'active' => false,
        'password' => bcrypt('correctpassword'),
    ]);
    $this->activeUser = User::factory()->create([
        'active' => true,
        'password' => bcrypt('correctpassword'),
    ]);
});

describe('Authentication', function () {
    it('does not authenticate a user with an invalid password', function () {
        $payload = ['email' => $this->activeUser->email, 'password' => 'wrongpassword'];

        $response = $this->postJson(route('login'), $payload);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonStructure(['message']);
    });
    it('does not authenticate a user with an invalid email', function () {
        $payload = ['email' => 'nonexistent@example.com', 'password' => 'correctpassword'];

        $response = $this->postJson(route('login'), $payload);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonStructure(['message']);
    });
    it('authenticates a user with correct credentials', function () {
        $payload = ['email' => $this->activeUser->email, 'password' => 'correctpassword'];

        $response = $this->postJson(route('login'), $payload);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['user', 'access_token']);
    });
    it('does not authenticate an inactive user', function () {
        $payload = ['email' => $this->inactiveUser->email, 'password' => 'correctpassword'];

        $response = $this->postJson(route('login'), $payload);

        $response->assertStatus(Response::HTTP_FORBIDDEN)
            ->assertJsonStructure(['message']);
    });
    it('logs out a user', function () {
        $token = $this->activeUser->createToken('test-token')->plainTextToken;
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson(route('logout'));
        $response->assertStatus(Response::HTTP_OK);
    });

    it('does not log out a user without a token', function () {
        $response = $this->postJson(route('logout'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    });

    it('does not log out a user with an invalid token', function () {
        $response = $this->withHeader('Authorization', 'Bearer invalidtoken')
            ->postJson(route('logout'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    });

    it('does not log out a user with an expired token', function () {
        $token = $this->activeUser->createToken('test-token')->plainTextToken;
        $this->activeUser->tokens()->update(['created_at' => now()->subMinutes(50)]);
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson(route('logout'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    });

    it('does not log out a user with a revoked token', function () {
        $token = $this->activeUser->createToken('test-token')->plainTextToken;
        $this->activeUser->tokens()->delete();
        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson(route('logout'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    });

    describe('Gets data from the logged-in user', function () {
        it('should return a 200 status code and proper JSON structure', function () {
            $userAuth = User::factory()->create();
            $roleAdminId = Role::where('slug', RolesEnum::ADMINISTRATOR->value)->first()->id;
            $userAuth->assignRole([$roleAdminId]);
            $response = $this->actingAs($userAuth)
                ->get(route('auth.myProfile'));
            
            $response->assertStatus(Response::HTTP_OK)
                ->assertJsonStructure([
                    'name',
                    'email',
                    'permissions',
            ])->dd('ok');
        });
    })->group('auth');
})->group('auth');
