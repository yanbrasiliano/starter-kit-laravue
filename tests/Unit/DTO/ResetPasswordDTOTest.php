<?php

namespace Tests\Unit\DTO;

use App\DTO\Password\ResetPasswordDTO;
use stdClass;

beforeEach(function () {
    $this->paramsDTO = new stdClass();
    $this->paramsDTO->email = fake('pt_BR')->email();
    $this->paramsDTO->token = fake('pt_BR')->text();
    $this->paramsDTO->password = fake('pt_BR')->password(8);
    $this->paramsDTO->password_confirmation = fake('pt_BR')->password(8);
});

describe('ResetPasswordDTOTest must have correct properties with correct types', function () {
    it('ResetPasswordDTOTest must have password and password_confirmation', function () {
        $resetPasswordDTO = new ResetPasswordDTO(
            $this->paramsDTO->email,
            $this->paramsDTO->token,
            $this->paramsDTO->password,
            $this->paramsDTO->password_confirmation,
        );

        expect($resetPasswordDTO)->toHaveProperty('email');
        expect($resetPasswordDTO)->toHaveProperty('token');
        expect($resetPasswordDTO)->toHaveProperty('password');
        expect($resetPasswordDTO)->toHaveProperty('password_confirmation');

        expect($resetPasswordDTO->email)->toBe($this->paramsDTO->email);
        expect($resetPasswordDTO->token)->toBe($this->paramsDTO->token);
        expect($resetPasswordDTO->password)->toBe($this->paramsDTO->password);
        expect($resetPasswordDTO->password_confirmation)->toBe($this->paramsDTO->password_confirmation);

        expect($resetPasswordDTO->email)->toBeString();
        expect($resetPasswordDTO->token)->toBeString();
        expect($resetPasswordDTO->password)->toBeString();
        expect($resetPasswordDTO->password_confirmation)->toBeString();
    });
})->group('dto');
