<?php

namespace Tests\Unit\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

describe('AuthenticationException', function () {
    it('returns the default error message when no parameters are passed', function () {
        $exception = new AuthenticationException();

        expect($exception->getMessage())->toBe('Unauthenticated.');
    });

    it('returns the custom error message when a message parameter is passed', function () {
        $customMessage = 'Usuário não autenticado. Realize o login para acessar o sistema';
        $exception = new AuthenticationException($customMessage);

        expect($exception->getMessage())->toBe($customMessage);
    });

    it('returns an empty guards array when no guards parameter is passed', function () {
        $exception = new AuthenticationException();

        expect($exception->guards())->toBe([]);
    });

    it('returns the correct guards array when guards parameter is passed', function () {
        $guards = ['web', 'api'];
        $exception = new AuthenticationException('Unauthenticated.', $guards);

        expect($exception->guards())->toBe($guards);
    });

    it('returns null for redirectTo when no redirectTo parameter is passed and no Request object is provided', function () {
        $exception = new AuthenticationException();
        $request = new Request();

        expect($exception->redirectTo($request))->toBeNull();
    });

    it('returns the correct redirectTo path when redirectTo parameter is passed', function () {
        $redirectTo = '/api/v1/login';
        $request = new Request();
        $exception = new AuthenticationException('Unauthenticated.', [], $redirectTo);

        expect($exception->redirectTo($request))->toBe($redirectTo);
    });
})->group('exceptions');
