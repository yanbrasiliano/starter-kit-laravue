<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class RoleIsAssignedToUserException extends Exception
{
    public $error;

    public function __construct(
        $message = 'Existem usuário(s) vinculado(s) ao perfil. Exclusão não permitida!',
        $code = Response::HTTP_CONFLICT,
        $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->code = $code;
        $this->error = 'O Perfil não é válido para exclusão.';
    }
}