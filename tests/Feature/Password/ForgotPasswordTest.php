<?php

namespace Tests\Feature\Password;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\{DB, Mail};

beforeEach(function () {
    $this->user = User::factory()->create();
});

describe('ForgotPasswordTest', function () {

    it('should return that email is required', function () {
        $payload = ['email' => null];
        $response = $this->postJson(route('forgot-password'), $payload);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'email' => [
                        'O campo e-mail é obrigatório.',
                    ],
                ],
            ]);
    })->group('password');

    it('should return that the email is invalid', function () {
        $payload = ['email' => fake('pt_BR')->text(20)];
        $response = $this->postJson(route('forgot-password'), $payload);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'email' => [
                        'O campo e-mail deve ser um endereço de e-mail válido.',
                    ],
                ],
            ]);
    })->group('password');

    it('should return that no user with that email address was found', function () {
        $payload = ['email' => fake('pt_BR')->email()];
        $response = $this->postJson(route('forgot-password'), $payload);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'email' => [
                        'Nenhum cadastro encontrado com o e-mail informado.',
                    ],
                ],
            ]);
    })->group('password');

    it('should return that the user profile cannot request a password change', function () {
        $payload = ['email' => $this->user->email];
        $response = $this->postJson(route('forgot-password'), $payload);
        $response->assertJsonStructure(['message']);
    })->group('password');

    it('should return status 204', function () {
        $user = User::factory()->create();
        $role = DB::table('roles')->where('slug', RolesEnum::REVIEWER)->first();
        $user->assignRole([$role->id]);
        Mail::fake();
        $payload = ['email' => $user->email];
        $response = $this->postJson(route('forgot-password'), $payload);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    })->group('password');
});
