<?php

declare(strict_types = 1);

namespace Tests\Feature\Api\Auth;

use App\Actions\Auth\ForgotPasswordAction;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Mail\SendForgetPasswordMail;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\{DB, Mail, Password};
use Illuminate\Support\{Fluent, Str};
use Mockery;
use ReflectionClass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

beforeEach(function () {
    $this->user = User::factory()->create();
});

describe('ForgotPasswordTest', function () {

    it('should return that email is required', function () {
        $response = $this->postJson(route('forgot-password'), ['email' => null]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => ['email' => ['O campo e-mail é obrigatório.']],
            ]);
    })->group('password');

    it('should return that the email is invalid', function () {
        $response = $this->postJson(route('forgot-password'), ['email' => fake('pt_BR')->text(20)]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => ['email' => ['O campo e-mail deve ser um endereço de e-mail válido.']],
            ]);
    })->group('password');

    it('should return that no user with that email address was found', function () {
        $response = $this->postJson(route('forgot-password'), ['email' => fake('pt_BR')->email()]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => ['email' => ['Nenhum cadastro encontrado com o e-mail informado.']],
            ]);
    })->group('password');

    it('should queue SendForgetPasswordMail when a valid user requests password reset', function () {
        Mail::fake();
        $user = User::factory()->create();

        $response = $this->postJson(route('forgot-password'), ['email' => $user->email]);

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        Mail::assertQueued(SendForgetPasswordMail::class, fn ($mail) => $mail->hasTo($user->email));
    })->group('password');

    it('should return status 204 when request is valid', function () {
        $user = User::factory()->create();

        $response = $this->postJson(route('forgot-password'), ['email' => $user->email]);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    })->group('password');

    it('should create a password reset token in the database', function () {
        $user = User::factory()->create();

        $this->postJson(route('forgot-password'), ['email' => $user->email])
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => mb_strtolower($user->email),
        ]);
    })->group('password');

    it('stores the reset token email in lowercase', function () {
        $user = User::factory()->create(['email' => 'john@example.com']);

        $this->postJson(route('forgot-password'), ['email' => 'JOHN@EXAMPLE.COM'])
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => 'john@example.com',
        ]);
    })->group('password');

    it('should rollback token creation if mail dispatch fails', function () {
        $user = User::factory()->create();

        Mail::shouldReceive('to->queue')
            ->once()
            ->andThrow(new HttpException(400, 'Mail failed'));

        $this->postJson(route('forgot-password'), ['email' => $user->email])
            ->assertStatus(Response::HTTP_BAD_REQUEST);

        $this->assertDatabaseCount('password_reset_tokens', 0);
    })->group('password');

    it('builds the mailable correctly with markdown and variables', function () {
        $user = User::factory()->make(['name' => 'John Doe', 'email' => 'john@example.com']);
        $token = Str::random(60);

        $mailable = new SendForgetPasswordMail($token, $user);
        $rendered = $mailable->render();

        expect($mailable->envelope()->subject)->toBe('Password Recovery Request SP System 1.0');
        expect($rendered)->toContain('John Doe');
        expect($rendered)->toContain($user->email);
    })->group('password');

    it('email content contains reset link and greeting', function () {
        $user = User::factory()->make(['name' => 'Mary']);
        $token = Str::random(60);
        $html = (new SendForgetPasswordMail($token, $user))->render();

        expect($html)->toContain('Mary');
        expect($html)->toContain(mb_trim($token));
        expect($html)->toContain('resetar-senha');
    })->group('password');

    it('should not include the token in email subject', function () {
        $user = User::factory()->make();
        $token = Str::random(60);
        $mail = new SendForgetPasswordMail($token, $user);

        expect($mail->envelope()->subject)->not->toContain($token);
    })->group('password');

    it('returns Fluent with all keys when key is null', function () {
        $user = User::factory()->create(['email' => 'john@example.com']);

        $req = ForgotPasswordRequest::create('/', 'POST', ['email' => $user->email]);
        $req->setContainer(app());
        $req->setRedirector(app('redirect'));
        $req->validateResolved();

        $fluent = $req->fluentParams();

        expect($fluent)->toBeInstanceOf(Fluent::class);
        expect($fluent->get('email'))->toBe('john@example.com');
        expect(array_keys($fluent->toArray()))->toBe(['email']);
    })->group('password');

    it('returns Fluent containing only the requested key when key is provided', function () {
        $user = User::factory()->create(['email' => 'jane@example.com']);

        $req = ForgotPasswordRequest::create('/', 'POST', ['email' => $user->email]);
        $req->setContainer(app());
        $req->setRedirector(app('redirect'));
        $req->validateResolved();

        $fluent = $req->fluentParams('email');

        expect($fluent->toArray())->toBe(['email' => 'jane@example.com']);
    })->group('password');

    it('action: processes reset link when broker returns RESET_LINK_SENT', function () {
        Mail::fake();
        $user = User::factory()->create();
        $params = new Fluent(['email' => $user->email]);

        Password::shouldReceive('sendResetLink')
            ->once()
            ->andReturnUsing(function ($data, $callback) use ($user) {
                $callback($user, 'FAKE_TOKEN');

                return Password::RESET_LINK_SENT;
            });

        app(ForgotPasswordAction::class)->execute($params);

        Mail::assertQueued(SendForgetPasswordMail::class);
    })->group('password');

    it('action: accepts string statuses as success', function () {
        Mail::fake();
        $user = User::factory()->create();
        $params = new Fluent(['email' => $user->email]);

        Password::shouldReceive('sendResetLink')
            ->once()
            ->andReturn('CUSTOM_STATUS');

        app(ForgotPasswordAction::class)->execute($params);

        Mail::assertNothingQueued();
    })->group('password');

    it('action: throws 400 when status is not successful', function () {
        $user = User::factory()->create();
        $params = new Fluent(['email' => $user->email]);

        Password::shouldReceive('sendResetLink')
            ->once()
            ->andReturn(false);

        try {
            app(ForgotPasswordAction::class)->execute($params);
            $this->fail('Should throw HttpException');
        } catch (HttpException $e) {
            expect($e->getStatusCode())->toBe(Response::HTTP_BAD_REQUEST);
        }
    })->group('password');

    it('action: rolls back transaction if mail callback throws error', function () {
        $user = User::factory()->create();
        $params = new Fluent(['email' => $user->email]);

        DB::table('password_reset_tokens')->truncate();

        Password::shouldReceive('sendResetLink')
            ->once()
            ->andReturnUsing(function () {
                throw new Exception('mail fail');
            });

        $this->expectException(Exception::class);

        app(ForgotPasswordAction::class)->execute($params);

        $this->assertDatabaseCount('password_reset_tokens', 0);
    })->group('password');

    it('action: callback receives correct user and token', function () {
        Mail::fake();
        $user = User::factory()->create();
        $params = new Fluent(['email' => $user->email]);

        Password::shouldReceive('sendResetLink')
            ->once()
            ->andReturnUsing(function ($data, $callback) use ($user) {
                $callback($user, 'TOKEN123');

                return Password::RESET_LINK_SENT;
            });

        app(ForgotPasswordAction::class)->execute($params);

        Mail::assertQueued(
            SendForgetPasswordMail::class,
            function ($mail) use ($user) {

                $ref = new ReflectionClass($mail);

                $tokenProp = $ref->getProperty('token');
                $tokenProp->setAccessible(true);
                $token = $tokenProp->getValue($mail);

                $userProp = $ref->getProperty('user');
                $userProp->setAccessible(true);
                $innerUser = $userProp->getValue($mail);

                return $token === 'TOKEN123' &&
                    $innerUser->id === $user->id;
            }
        );
    })->group('password');

    it('action: passes correct array to broker', function () {
        $user = User::factory()->create();
        $params = new Fluent(['email' => $user->email]);

        Password::shouldReceive('sendResetLink')
            ->once()
            ->with(['email' => $user->email], Mockery::type('callable'))
            ->andReturn(Password::RESET_LINK_SENT);

        app(ForgotPasswordAction::class)->execute($params);
    })->group('password');
})->group('forgotPasswordTest');
