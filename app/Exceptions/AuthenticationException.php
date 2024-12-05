<?php

namespace App\Exceptions;

use Exception;

// @codeCoverageIgnoreStart

class AuthenticationException extends Exception
{
    /**
     * @var array<int, string> $guards
     */
    protected array $guards;

    /**
     * @var string|null $redirectTo
     */
    protected ?string $redirectTo;

    /**
     * @param string $message
     * @param array<int, string> $guards
     * @param string|null $redirectTo
     */
    public function __construct(string $message = 'Não Autenticado', array $guards = [], ?string $redirectTo = null)
    {
        parent::__construct($message);

        $this->guards = $guards;
        $this->redirectTo = $redirectTo;
    }

    /**
     * @return array<int, string>
     */
    public function guards(): array
    {
        return $this->guards;
    }

    /**
     * @return string|null
     */
    public function redirectTo(): ?string
    {
        return $this->redirectTo;
    }
}
// @codeCoverageIgnoreEnd
