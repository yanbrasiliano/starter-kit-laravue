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

  public function register(): void {}

  public function render($request, Throwable $exception)
  {
    $status = match (true) {
      $exception instanceof InvalidCredentialsException => (int) ($exception->getCode() ?: Response::HTTP_BAD_REQUEST),
      $exception instanceof AuthenticationException => Response::HTTP_UNAUTHORIZED,
      $exception instanceof UnactivatedUserException => (int) ($exception->getCode() ?: Response::HTTP_FORBIDDEN),
      default => Response::HTTP_INTERNAL_SERVER_ERROR,
    };

    if ($status !== Response::HTTP_INTERNAL_SERVER_ERROR || $exception->getCode() !== 0) {
      return response()->json([
        'error' => $exception->error ?? 'Erro',
        'message' => $exception->getMessage() ?: 'Um erro inesperado aconteceu. Por favor, tente novamente.',
      ], $status);
    }

    return parent::render($request, $exception);
  }
}
