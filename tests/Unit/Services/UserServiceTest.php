<?php

namespace Tests\Unit\Services;

use App\DTO\Paginate\PaginateDataDTO;
use App\DTO\Paginate\PaginateParamsDTO;
use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\DTO\User\UserDTO;
use App\Mail\AccountDeletionNotification;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

beforeEach(function () {
    $this->users = User::factory(20)->create();
    $this->userAuth = User::factory()->create();
    $this->role = DB::table('roles')->first()->id;
});

describe('Lists users registered in the system', function () {
    it('returns the users registered in the system', function () {
        expect(app(UserService::class)->index(
            new PaginateParamsDTO(fake('pt_BR')->randomNumber())
        ))->toBeInstanceOf(PaginateDataDTO::class);
    });
});

describe('Create new users', function () {
    it('return the user registered in the system without generating a random password', function () {
        expect(app(UserService::class)->create(
            new CreateUserDTO(
                fake('pt_BR')->name(),
                fake('pt_BR')->email(),
                $this->role,
                preg_replace('/\D/', '', fake('pt_BR')->cpf()),
                fake('pt_BR')->password(),
                fake('pt_BR')->randomElement([0, 1]),
                0
            )
        ))->toBeInstanceOf(UserDTO::class);
    })->skip('send_random_password fall the test because the mailpit server is not configured');

    it('return the user registered in the system with generating a random password', function () {
        expect(app(UserService::class)->create(
            new CreateUserDTO(
                fake('pt_BR')->name(),
                fake('pt_BR')->email(),
                $this->role,
                preg_replace('/\D/', '', fake('pt_BR')->cpf()),
                fake('pt_BR')->password(),
                fake('pt_BR')->randomElement([0, 1]),
                1
            )
        ))->toBeInstanceOf(UserDTO::class);
    });

    it('returns error when passing non-existent role at user creation', function () {
        app(UserService::class)->create(
            new CreateUserDTO(
                fake('pt_BR')->name(),
                fake('pt_BR')->email(),
                500000,
                preg_replace('/\D/', '', fake('pt_BR')->cpf()),
                fake('pt_BR')->password(),
                fake('pt_BR')->randomElement([0, 1]),
                1
            )
        );
    })->throws(RoleDoesNotExist::class);
});
describe('Updates user data', function () {
    it('returns the updated user data without notifying the status activation', function () {
        expect(app(UserService::class)->update(
            $this->users->first()->id,
            new UpdateUserDTO(
                name: fake('pt_BR')->name(),
                email: fake('pt_BR')->email(),
                active: fake('pt_BR')->randomElement([0, 1]),
                cpf: preg_replace('/\D/', '', fake('pt_BR')->cpf()),
                password: fake('pt_BR')->password(),
                role_id: $this->role,
                notify_status: 0
            )
        ))->toBeInstanceOf(UserDTO::class);
    })->skip('send_random_password fall the test because the mailpit server is not configured');

    it('returns updated user data notifying status activation', function () {
        expect(app(UserService::class)->update(
            $this->users->first()->id,
            new UpdateUserDTO(
                name: fake('pt_BR')->name(),
                email: fake('pt_BR')->email(),
                active: fake('pt_BR')->randomElement([0, 1]),
                cpf: preg_replace('/\D/', '', fake('pt_BR')->cpf()),
                role_id: $this->role,
                password: fake('pt_BR')->password(),
                notify_status: 1
            )
        ))->toBeInstanceOf(UserDTO::class);
    });

    it('returns error when updating a user that does not exist', function () {
        app(UserService::class)->update(
            111111,
            new UpdateUserDTO(
                name: fake('pt_BR')->name(),
                email: fake('pt_BR')->email(),
                active: fake('pt_BR')->randomElement([0, 1]),
                cpf: preg_replace('/\D/', '', fake('pt_BR')->cpf()),
                role_id: $this->role,
                password: fake('pt_BR')->password(),
                notify_status: 1
            )
        );
    })->throws(ModelNotFoundException::class);

    it('returns error when passing non-existent role at user update', function () {
        app(UserService::class)->update(
            $this->users->first()->id,
            new UpdateUserDTO(
                name: fake('pt_BR')->name(),
                email: fake('pt_BR')->email(),
                role_id: 500000,
                cpf: preg_replace('/\D/', '', fake('pt_BR')->cpf()),
                password: fake('pt_BR')->password(),
                active: fake('pt_BR')->randomElement([0, 1]),
                notify_status: 1
            )
        );
    })->throws(RoleDoesNotExist::class);
});

describe('Delete user data', function () {
    it('should delete a user and send email notification', function () {
        $user = $this->users->first();
        $this->actingAs($this->userAuth);

        Mail::fake();

        app(UserService::class)->delete($user->id, 'Test deletion reason');

        expect(User::find($user->id))->toBeNull();
        Mail::assertSent(AccountDeletionNotification::class);
    });

    it('throws ModelNotFoundException when querying user that does not exist', function () {
        $this->actingAs($this->userAuth);

        expect(function () {
            app(UserService::class)->delete(111111, 'Test deletion reason');
        })->toThrow(ModelNotFoundException::class);
    });
});
