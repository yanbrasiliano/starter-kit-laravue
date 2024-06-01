<?php

namespace Tests\Feature\Users;

use App\Mail\SendVerifyEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use function Pest\Laravel\{actingAs, get, post};

beforeEach(function () {
  createRoles();
  $this->users = createUsers();
  $this->asAdmin = asAdmin();
});

describe('Users Management', function () {
  describe('Listing Users', function () {
    it(
      'should return a 200 status code and proper JSON structure',
      function (array $paginationStructure) {

        actingAs($this->asAdmin)
          ->get(route('users.list'))
          ->assertStatus(Response::HTTP_OK)
          ->assertJsonStructure($paginationStructure);
      }
    )->with('paginationStructure');
  });

  describe('Querying User Data', function () {
    it(
      'should return a 200 status code and proper JSON structure for valid user ID',
      function (array $paginationStructure) {

        actingAs($this->asAdmin)
          ->get(route('users.list', [$this->asAdmin->id]))
          ->assertStatus(Response::HTTP_OK)
          ->assertJsonStructure($paginationStructure);
      }
    )->with('paginationStructure');

    it('should return a 404 status code for invalid user ID', function () {
      actingAs($this->asAdmin)
        ->get(route('users.view', [111111]))
        ->assertStatus(Response::HTTP_NOT_FOUND);
    });
  });

  describe('Registering Users', function () {
    it(
      'should return a 200 status code and proper JSON structure for valid user data',
      function (array $registerUser, array $validJsonStructure) {

        Mail::fake();

        actingAs($this->asAdmin)
          ->post(route('users.register'), $registerUser)
          ->assertStatus(Response::HTTP_OK)
          ->assertExactJson(["message" => "Um e-mail de confirmação foi encaminhado. Por favor, realize os procedimentos para ativação da sua conta."]);
      }
    )
      ->with('registerUser')
      ->with('validJsonStructure');

    it(
      'should return a 422 status code when name is not provided',
      function (array $nameNotProvided) {

        actingAs($this->asAdmin)
          ->post(route('users.create'), $nameNotProvided)
          ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
          ->assertJson([
            'errors' => [
              'name' => [
                'O campo Nome é obrigatório.',
              ],
            ],
          ]);
      }
    )->with('nameNotProvided');

    it('should return a 422 status code when email is invalid', function (array $invalidEmail) {

      actingAs($this->asAdmin)
        ->post(route('users.create'), $invalidEmail)
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJson([
          'errors' => [
            'email' => [
              'O E-mail inserido não é válido.',
            ],
          ],
        ]);
    })->with('invalidEmail');

    it(
      'should return a 422 status code when the email entered has already been registered',
      function (array $emailAlreadyExists) {

        actingAs($this->asAdmin)
          ->post(route('users.create'), $emailAlreadyExists)
          ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
          ->assertJson([
            'errors' => [
              'email' => [
                'O E-mail inserido já está em uso.',
              ],
            ],
          ]);
      }
    )->with('emailAlreadyExists');

    it(
      'should return a 422 status code when status informed user is invalid',
      function (array $invalidStatus) {

        actingAs($this->asAdmin)
          ->post(route('users.create'), $invalidStatus)
          ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
          ->assertJson([
            'errors' => [
              'active' => [
                'O Status inserido não é válido.',
              ],
            ],
          ]);
      }
    )->with('invalidStatus');

    it(
      'should return a 422 status code when role informed user is invalid',
      function (array $invalidRole) {

        actingAs($this->asAdmin)
          ->post(route('users.create'), $invalidRole)
          ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
          ->assertJson([
            'errors' => [
              'role_id' => [
                'O Perfil é inválido.',
              ],
            ],
          ]);
      }
    )->with('invalidRole');

    it(
      'should return a 422 status code when CPF informed is invalid',
      function (array $invalidCPF) {

        actingAs($this->asAdmin)->post(route('users.create'), $invalidCPF)
          ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
          ->assertJson([
            'errors' => [
              'cpf' => [
                'O CPF inserido não é um cpf válido.',
              ],
            ],
          ]);
      }
    )->with('invalidCPF');
  });

  describe('Updating Users', function () {
    it(
      'should return a 200 status code and proper JSON structure for valid user ID and data',
      function (array $updateDataUser, array $userJsonValidStructure) {

        actingAs($this->asAdmin)
          ->put(route('users.edit', [$this->asAdmin->id]), $updateDataUser)
          ->assertStatus(Response::HTTP_OK)
          ->assertJsonStructure($userJsonValidStructure);
      }
    )
      ->with('updateUserData')
      ->with('userJsonValidStructure');

    it(
      'should return a 422 status code when name is not provided',
      function (array $nameNotProvided) {

        actingAs($this->asAdmin)
          ->put(route('users.edit', [$this->asAdmin->id]), $nameNotProvided)
          ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
          ->assertJson([
            'errors' => [
              'name' => [
                'O campo Nome é obrigatório.',
              ],
            ],
          ]);
      }
    )->with('nameNotProvided');

    it(
      'should return a 422 status code when email is invalid',
      function (array $invalidEmail) {

        actingAs($this->asAdmin)
          ->put(route('users.edit', [$this->asAdmin->id]), $invalidEmail)
          ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
          ->assertJson([
            'errors' => [
              'email' => [
                'O E-mail inserido não é válido.',
              ],
            ],
          ]);
      }
    )->with('invalidEmail');

    it(
      'should return a 422 status code when the email entered has already been registered',
      function (array $emailAlreadyExists) {

        actingAs($this->asAdmin)
          ->put(route('users.edit', [$this->asAdmin->id]), $emailAlreadyExists)
          ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
          ->assertJson([
            'errors' => [
              'email' => [
                'O E-mail inserido já está em uso.',
              ],
            ],
          ]);
      }
    )->with('emailAlreadyExists');

    it(
      'should return a 422 status code when status informed user is invalid',
      function (array $invalidStatus) {

        actingAs($this->asAdmin)
          ->put(route('users.edit', [$this->asAdmin->id]), $invalidStatus)
          ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
          ->assertJson([
            'errors' => [
              'active' => [
                'O Status inserido não é válido.',
              ],
            ],
          ]);
      }
    )->with('invalidStatus');

    it(
      'should return a 422 status code when role informed user is invalid',
      function (array $invalidRoleData) {

        actingAs($this->asAdmin)
          ->put(route('users.edit', [$this->asAdmin->id]), $invalidRoleData)
          ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
          ->assertJson([
            'errors' => [
              'role_id' => [
                'O Perfil é inválido.',
              ],
            ],
          ]);
      }
    )->with('invalidRoleData');
  });

  describe('Deleting Users', function () {
    it('should delete a user and return a 204 status code for valid user ID', function () {
      $user = createUser();

      Mail::fake();
      actingAs($this->asAdmin)
        ->delete(route('users.delete', [$user->id]), ['reason' => 'Test deletion reason'])
        ->assertStatus(Response::HTTP_NO_CONTENT)
        ->assertNoContent();

      expect(User::find($user->id))->toBeNull();
    });

    it('should return a 404 status code for invalid user ID', function () {

      actingAs($this->asAdmin)
        ->delete(route('users.delete', [111111]), ['reason' => 'Test deletion reason'])
        ->assertStatus(Response::HTTP_NOT_FOUND)
        ->assertJson(['message' => 'No query results for model [App\\Models\\User] ' . '111111']);
    });
  });

  describe('Register Users', function () {
    it('Should return status 200 of registered user', function (array $registerUser) {
      Mail::fake();

      $resp = post(route('users.register'), $registerUser);

      $resp->assertStatus(Response::HTTP_OK)
        ->assertJson(['message' => 'Um e-mail de confirmação foi encaminhado. Por favor, realize os procedimentos para ativação da sua conta.']);
    })
      ->with('registerUser');
  });

  describe('User email verification', function () {
    it('should return that the users email has been verified', function () {

      $user = createUser([
        'email_verified_at' => null,
      ]);

      $url = createTemporaryUrlForUser($user, Carbon::now()->addHours(Config::get('auth.verification.expire', 48)));

      get($url)
        ->assertStatus(Response::HTTP_OK)
        ->assertJson(['message' => 'O seu cadastro foi verificado com sucesso!']);
    });

    it('should return that the email is already validated', function () {
      $user = createUser([
        'email_verified_at' => now(),
      ]);

      $url = createTemporaryUrlForUser($user, Carbon::now()->addMinutes(30));

      get($url)
        ->assertJson(['message' => 'Seu cadastro já foi validado! Por favor, aguarde até que um administrador realize a liberação do seu acesso.']);
    });

    it('should return that the token is invalid', function () {

      $user = createUser([
        'email_verified_at' => now(),
      ]);

      $url = createTemporaryUrlForUser($user, Carbon::now()->subHours(1));

      get($url)
        ->assertJson(['message' => 'Invalid signature.']);
    });
  });
});
