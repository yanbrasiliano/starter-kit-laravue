<?php

namespace Tests\Feature\Password;

use App\Enums\RolesEnum;
use App\Mail\SendForgetPasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

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

    it('should queue the SendForgetPasswordMail when a valid reviewer requests password reset', function () {

        $user = User::factory()->create();

        DB::table('roles')->updateOrInsert(
            ['slug' => RolesEnum::REVIEWER->value],
            [
                'name' => 'Reviewer',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $role = DB::table('roles')->where('slug', RolesEnum::REVIEWER->value)->first();
        $user->assignRole([$role->id]);

        $payload = ['email' => $user->email];
        $response = $this->postJson(route('forgot-password'), $payload);

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        Mail::assertQueued(SendForgetPasswordMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    });

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

        DB::table('roles')->updateOrInsert(
            ['slug' => RolesEnum::REVIEWER],
            [
                'name' => 'Reviewer',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $role = DB::table('roles')->where('slug', RolesEnum::REVIEWER)->first();

        $user->assignRole([$role->id]);

        $payload = ['email' => $user->email];
        $response = $this->postJson(route('forgot-password'), $payload);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    })->group('password');

});
