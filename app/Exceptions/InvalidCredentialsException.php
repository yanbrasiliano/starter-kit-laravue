<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class InvalidCredentialsException extends Exception
{
    public $error;

    public function __construct(
        $message = 'Usuário ou senha inválidos',
        $code = Response::HTTP_UNAUTHORIZED,
        $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->code = $code;
        $this->error = 'Credenciais inválidas';
    }
}
