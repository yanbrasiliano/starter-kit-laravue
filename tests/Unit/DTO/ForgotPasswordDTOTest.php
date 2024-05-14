<?php

namespace Tests\Unit\DTO;

use App\DTO\Password\ForgotPasswordDTO;

describe('ForgotPasswordDTOTest must have correct properties with correct types', function () {
    it('ForgotPasswordDTOTest must have email', function () {
        $forgotPasswordDTO = new ForgotPasswordDTO('example@example.com');

        expect($forgotPasswordDTO)->toHaveProperty('email');

        expect($forgotPasswordDTO->email)->toBe('example@example.com');

        expect($forgotPasswordDTO->email)->toBeString();
    });
})->group('dto');
