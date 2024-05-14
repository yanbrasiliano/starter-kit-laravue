<?php

namespace Tests\Feature\Users;

use App\Enums\RolesEnum;
use App\Mail\SendVerifyEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->baseUrl = 'api/v1/users';
    $this->users = User::factory(20)->create();
    $this->userAuth = User::factory()->create();
    $roleAdminId = Role::where('slug', RolesEnum::ADMINISTRATOR->value)->first()->id;
    $this->userAuth->assignRole([$roleAdminId]);
    $this->token = $this->userAuth->createToken('test-token')->plainTextToken;
});

describe('Users Management', function () {
    describe('Listing Users', function () {
        it('should return a 200 status code and proper JSON structure', function () {
            $response = $this->actingAs($this->userAuth)->get($this->baseUrl);
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

    describe('Querying User Data', function () {
        it('should return a 200 status code and proper JSON structure for valid user ID', function () {
            $response = $this->actingAs($this->userAuth)->get("{$this->baseUrl}/{$this->userAuth->id}");
            $response->assertStatus(Response::HTTP_OK);
            $response->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'cpf',
                    'active',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                    'roles',
                ],
            ]);
        });

        it('should return a 404 status code for invalid user ID', function () {
            $response = $this->actingAs($this->userAuth)->get("{$this->baseUrl}/10000");
            $response->assertStatus(Response::HTTP_NOT_FOUND);
        });
    });

    describe('Registering Users', function () {
        it('should return a 200 status code and proper JSON structure for valid user data', function () {
            $response = $this->actingAs($this->userAuth)->post($this->baseUrl, [
                'cpf' => preg_replace('/\D/', '', fake('pt_BR')->cpf()),
                'name' => fake('pt_BR')->name(),
                'email' => fake('pt_BR')->email(),
                'password' => fake('pt_BR')->password(10),
                'active' => fake('pt_BR')->randomElement([0, 1]),
                'send_random_password' => true,
                'role_id' => fake('pt_BR')->randomElement([1]),
            ]);
            $response->assertStatus(Response::HTTP_OK);
            $response->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'cpf',
                    'active',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                    'roles',
                ],
            ]);
        });

        it('should return a 422 status code when name is not provided', function () {
            $response = $this->actingAs($this->userAuth)->post($this->baseUrl, [
                'name' => null,
                'email' => fake('pt_BR')->email(),
                'password' => fake('pt_BR')->password(10),
                'active' => fake('pt_BR')->randomElement([0, 1]),
                'send_random_password' => true,
                'role_id' => fake('pt_BR')->randomElement([1]),
            ]);
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
            $response->assertJson([
                'errors' => [
                    'name' => [
                        'O campo Nome é obrigatório.',
                    ],
                ],
            ]);
        });

        it('should return a 422 status code when email is invalid', function () {
            $response = $this->actingAs($this->userAuth)->post($this->baseUrl, [
                'name' => fake('pt_BR')->name(),
                'email' => fake('pt_BR')->text(),
                'password' => fake('pt_BR')->password(10),
                'active' => fake('pt_BR')->randomElement([0, 1]),
                'send_random_password' => true,
                'role_id' => fake('pt_BR')->randomElement([1]),
            ]);
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
            $response->assertJson([
                'errors' => [
                    'email' => [
                        'O E-mail inserido não é válido.',
                    ],
                ],
            ]);
        });

        it('should return a 422 status code when the email entered has already been registered', function () {
            $response = $this->actingAs($this->userAuth)->post($this->baseUrl, [
                'name' => fake('pt_BR')->name(),
                'email' => $this->users->first()->email,
                'password' => fake('pt_BR')->password(10),
                'active' => 1,
                'send_random_password' => true,
                'role_id' => fake('pt_BR')->randomElement(['1']),
            ]);
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
            $response->assertJson([
                'errors' => [
                    'email' => [
                        'O E-mail inserido já está em uso.',
                    ],
                ],
            ]);
        });

        it('should return a 422 status code when status informed user is invalid', function () {
            $response = $this->actingAs($this->userAuth)->post($this->baseUrl, [
                'name' => fake('pt_BR')->name(),
                'email' => fake('pt_BR')->email(),
                'password' => fake('pt_BR')->password(10),
                'active' => 10,
                'send_random_password' => true,
                'role_id' => fake('pt_BR')->randomElement([1]),
            ]);
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
            $response->assertJson([
                'errors' => [
                    'active' => [
                        'O Status inserido não é válido.',
                    ],
                ],
            ]);
        });

        it('should return a 422 status code when role informed user is invalid', function () {
            $response = $this->actingAs($this->userAuth)->post($this->baseUrl, [
                'name' => fake('pt_BR')->name(),
                'email' => fake('pt_BR')->email(),
                'password' => fake('pt_BR')->password(10),
                'active' => 10,
                'send_random_password' => true,
                'role_id' => fake('pt_BR')->randomElement(['10000']),
            ]);
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
            $response->assertJson([
                'errors' => [
                    'role_id' => [
                        'O Perfil é inválido.',
                    ],
                ],
            ]);
        });

        it('should return a 422 status code when CPF informed is invalid', function () {
            $response = $this->actingAs($this->userAuth)->post($this->baseUrl, [
                'cpf' => '000000000',
                'name' => fake('pt_BR')->name(),
                'email' => fake('pt_BR')->email(),
                'password' => fake('pt_BR')->password(10),
                'active' => 1,
                'send_random_password' => true,
                'role_id' => fake('pt_BR')->randomElement([1]),
            ]);
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
            $response->assertJson([
                'errors' => [
                    'cpf' => [
                        'O CPF inserido não é um cpf válido.',
                    ],
                ],
            ]);
        });
    });

    describe('Updating Users', function () {
        it('should return a 200 status code and proper JSON structure for valid user ID and data', function () {
            $response = $this->actingAs($this->userAuth)->put("{$this->baseUrl}/{$this->userAuth->id}", [
                'cpf' => preg_replace('/\D/', '', fake('pt_BR')->cpf()),
                'name' => fake('pt_BR')->name(),
                'email' => fake('pt_BR')->email(),
                'password' => fake('pt_BR')->password(10),
                'active' => fake('pt_BR')->randomElement([0, 1]),
                'role_id' => fake('pt_BR')->randomElement([1]),
            ]);
            $response->assertStatus(Response::HTTP_OK);
            $response->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'cpf',
                    'active',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                    'roles',
                ],
            ]);
        });

        it('should return a 422 status code when name is not provided', function () {
            $response = $this->actingAs($this->userAuth)->put("{$this->baseUrl}/{$this->userAuth->id}", [
                'name' => null,
                'email' => fake('pt_BR')->email(),
                'password' => fake('pt_BR')->password(10),
                'active' => fake('pt_BR')->randomElement([0, 1]),
                'send_random_password' => true,
                'role_id' => fake('pt_BR')->randomElement([1]),
            ]);
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
            $response->assertJson([
                'errors' => [
                    'name' => [
                        'O campo Nome é obrigatório.',
                    ],
                ],
            ]);
        });

        it('should return a 422 status code when email is invalid', function () {
            $response = $this->actingAs($this->userAuth)->put("{$this->baseUrl}/{$this->userAuth->id}", [
                'name' => fake('pt_BR')->name(),
                'email' => fake('pt_BR')->text(),
                'password' => fake('pt_BR')->password(10),
                'active' => fake('pt_BR')->randomElement([0, 1]),
                'send_random_password' => true,
                'role_id' => fake('pt_BR')->randomElement([1]),
            ]);
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
            $response->assertJson([
                'errors' => [
                    'email' => [
                        'O E-mail inserido não é válido.',
                    ],
                ],
            ]);
        });

        it('should return a 422 status code when the email entered has already been registered', function () {
            $response = $this->actingAs($this->userAuth)->put("{$this->baseUrl}/{$this->userAuth->id}", [
                'name' => fake('pt_BR')->name(),
                'email' => $this->users->first()->email,
                'password' => fake('pt_BR')->password(10),
                'active' => 1,
                'send_random_password' => true,
                'role_id' => fake('pt_BR')->randomElement(['1']),
            ]);
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
            $response->assertJson([
                'errors' => [
                    'email' => [
                        'O E-mail inserido já está em uso.',
                    ],
                ],
            ]);
        });

        it('should return a 422 status code when status informed user is invalid', function () {
            $response = $this->actingAs($this->userAuth)->put("{$this->baseUrl}/{$this->userAuth->id}", [
                'name' => fake('pt_BR')->name(),
                'email' => fake('pt_BR')->email(),
                'password' => fake('pt_BR')->password(10),
                'active' => 10,
                'send_random_password' => true,
                'role_id' => fake('pt_BR')->randomElement([1]),
            ]);
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
            $response->assertJson([
                'errors' => [
                    'active' => [
                        'O Status inserido não é válido.',
                    ],
                ],
            ]);
        });

        it('should return a 422 status code when role informed user is invalid', function () {
            $response = $this->actingAs($this->userAuth)->put("{$this->baseUrl}/{$this->userAuth->id}", [
                'name' => fake('pt_BR')->name(),
                'email' => fake('pt_BR')->email(),
                'password' => fake('pt_BR')->password(10),
                'active' => 10,
                'send_random_password' => true,
                'role_id' => fake('pt_BR')->randomElement(['10000']),
            ]);
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
            $response->assertJson([
                'errors' => [
                    'role_id' => [
                        'O Perfil é inválido.',
                    ],
                ],
            ]);
        });
    });

    describe('Deleting Users', function () {
        it('should delete a user and return a 204 status code for valid user ID', function () {
            $user = $this->users->first();
            $url = "{$this->baseUrl}/{$user->id}";
            $reason = 'Test deletion reason';

            $response = $this->actingAs($this->userAuth)->delete($url, ['reason' => $reason]);

            $response->assertStatus(Response::HTTP_NO_CONTENT);
            expect(User::find($user->id))->toBeNull();
            $response->assertNoContent();
        });

        it('should return a 404 status code for invalid user ID', function () {
            $invalidUserId = 10000;
            $url = "{$this->baseUrl}/{$invalidUserId}";
            $reason = 'Test deletion reason';

            $response = $this->actingAs($this->userAuth)->delete($url, ['reason' => $reason]);

            $response->assertStatus(Response::HTTP_NOT_FOUND);
            $response->assertJson(['message' => 'No query results for model [App\\Models\\User] '.$invalidUserId]);
        });
    });

    describe('Register Users', function () {
        it('Should return status 200 of registered user', function () {

            Mail::fake();

            $pass = fake('pt_BR')->password();
            $response = $this->actingAs($this->userAuth)->post(route('users.register'), [
                'name' => fake('pt_BR')->name(),
                'email' => fake('pt_BR')->email(),
                'password' => $pass,
                'password_confirmation' => $pass,
                'cpf' => preg_replace('/\D/', '', fake('pt_BR')->cpf()),
                'role' => RolesEnum::REVIEWER->value,
            ]);

            $response->assertStatus(Response::HTTP_OK);
            $response->assertJson(['message' => 'Um e-mail de confirmação foi encaminhado. Por favor, realize os procedimentos para ativação da sua conta.']);
        });

        it('should return that the email cannot be used', function () {

            Mail::fake();

            $pass = fake('pt_BR')->password(8);
            $response = $this->actingAs($this->userAuth)->post(route('users.register'), [
                'name' => fake('pt_BR')->name(),
                'email' => 'test@uefs.com',
                'password' => $pass,
                'password_confirmation' => $pass,
                'cpf' => preg_replace('/\D/', '', fake('pt_BR')->cpf()),
                'role' => RolesEnum::REVIEWER->value,
            ]);

            Mail::assertNothingQueued(SendVerifyEmail::class);
            $response->assertJson(['message' => 'O email informado não pode ser utilizado para esse perfil de usuário.']);
        });
    });

    describe('User email verification', function () {
        it('should return that the users email has been verified', function () {

            $user = User::factory()->create([
                'email_verified_at' => null,
            ]);

            $url = URL::temporarySignedRoute(
                'users.verify',
                Carbon::now()->addHours(Config::get('auth.verification.expire', 48)),
                [
                    'id' => $user->getKey(),
                    'hash' => sha1($user->getEmailForVerification()),
                ]
            );

            $response = $this->get($url);
            $response->assertStatus(Response::HTTP_OK);
            $response->assertJson(['message' => 'O seu cadastro foi verificado com sucesso!']);
        });

        it('should return that the email is already validated', function () {

            $user = User::factory()->create([
                'email_verified_at' => now(),
            ]);

            $url = URL::temporarySignedRoute(
                'users.verify',
                Carbon::now()->addHours(Config::get('auth.verification.expire', 48)),
                [
                    'id' => $user->getKey(),
                    'hash' => sha1($user->getEmailForVerification()),
                ]
            );

            $response = $this->get($url);
            $response->assertJson(['message' => 'Seu cadastro já foi validado! Por favor, aguarde até que um administrador realize a liberação do seu acesso.']);
        });

        it('should return that the token is invalid', function () {

            $user = User::factory()->create([
                'email_verified_at' => now(),
            ]);

            $url = URL::temporarySignedRoute(
                'users.verify',
                Carbon::now()->subHours(1),
                [
                    'id' => $user->getKey(),
                    'hash' => sha1($user->getEmailForVerification()),
                ]
            );

            $response = $this->get($url);
            $response->assertJson(['message' => 'Invalid signature.']);
        });
    });
});
