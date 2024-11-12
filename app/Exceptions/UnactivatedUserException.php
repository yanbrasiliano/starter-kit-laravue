<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class UnactivatedUserException extends Exception
{
    public $error;

    public function __construct(
        $message = 'O Usuário não está ativo. Por favor contate o administrador do sistema.',
        $code = Response::HTTP_FORBIDDEN,
        $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->code = $code;
        $this->error = 'Usuário não ativado';
    }
}
