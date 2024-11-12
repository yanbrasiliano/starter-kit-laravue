<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule as Rule;

class ValidateCPF implements Rule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cpf = preg_replace('/\D/', '', $value);

        // Early return if the CPF does not have exactly 11 digits
        if (strlen($cpf) != 11) {
            $fail($this->message());

            return; // Ensure no further validation is performed if this fails
        }

        // Check for repeated digits pattern like '11111111111'
        if (preg_match("/^{$cpf[0]}{11}$/", $cpf)) {
            $fail($this->message());

            return;
        }

        // Calculating first check digit
        $sum = 0;

        for ($i = 0; $i < 9; $i++) {
            $sum += intval($cpf[$i]) * (10 - $i);
        }
        $remainder = $sum % 11;
        $firstCheckDigit = ($remainder < 2) ? 0 : 11 - $remainder;

        // Add more checks before accessing cpf[9]
        if (!isset($cpf[9]) || $cpf[9] != $firstCheckDigit) {
            $fail($this->message());

            return;
        }

        // Calculating second check digit
        $sum = 0;

        for ($i = 0; $i < 10; $i++) {
            $sum += intval($cpf[$i]) * (11 - $i);
        }
        $remainder = $sum % 11;
        $secondCheckDigit = ($remainder < 2) ? 0 : 11 - $remainder;

        // Add more checks before accessing cpf[10]
        if (!isset($cpf[10]) || $cpf[10] != $secondCheckDigit) {
            $fail($this->message());
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O :attribute inserido não é um cpf válido.';
    }
}
