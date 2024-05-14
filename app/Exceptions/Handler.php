<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof InvalidCredentialsException) {
            return response()->json([
                'error' => $exception->error,
                'message' => $exception->getMessage(),
            ], $exception->getCode());
        }

        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'error' => 'Não autenticado',
                'message' => $exception->getMessage(),
            ], Response::HTTP_UNAUTHORIZED);
        }
        if ($exception instanceof UnactivatedUserException) {
            return response()->json([
                'error' => $exception->error,
                'message' => $exception->getMessage(),
            ], $exception->getCode());
        }

        if ($exception->getCode() !== 0) {
            return response()->json([
                'error' => $exception?->error ?? 'Error',
                'message' => $exception->getMessage(),
            ], $exception->getCode());
        }

        return parent::render($request, $exception);
    }
}
