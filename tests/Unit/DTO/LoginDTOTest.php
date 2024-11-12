<?php

namespace Tests\Unit\DTO;

use App\DTO\Authenticate\LoginDTO;

describe('LoginDTO must have correct properties with correct types', function () {
    it('LoginDTO must have email and password', function () {
        $loginDTO = new LoginDTO(email: 'example@example.com', password: 'password123');
        expect($loginDTO)->toHaveProperty('email');
        expect($loginDTO)->toHaveProperty('password');

        expect($loginDTO->email)->toBe('example@example.com');
        expect($loginDTO->password)->toBe('password123');

        expect($loginDTO->email)->toBeString();
        expect($loginDTO->password)->toBeString();
    });
})->group('dto');
