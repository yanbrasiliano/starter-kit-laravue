<?php

namespace Tests\Unit\Repositories;

use App\DTO\Paginate\PaginateParamsDTO;
use App\Models\{DeleteReason, User};
use App\Repositories\EloquentRepository\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    $this->users = User::factory(20)->create();
    $this->userAuth = User::factory()->create();
    $this->role = DB::table('roles')->first()->id;
});

describe('Listing users in the repository', function () {
    it('returns the users registered in the database', function () {
        expect(app(UserRepository::class)->list(
            new PaginateParamsDTO()
        ))->toBeInstanceOf(LengthAwarePaginator::class);
    });

    it('returns the users registered in the database, sorted by name ', function () {
        expect(app(UserRepository::class)->list(
            new PaginateParamsDTO(
                column: 'name',
                order: 'desc'
            )
        ))->toBeInstanceOf(LengthAwarePaginator::class);
    });

    it('returns the users registered in the database, sorted by email ', function () {
        expect(app(UserRepository::class)->list(
            new PaginateParamsDTO(
                column: 'email',
            )
        ))->toBeInstanceOf(LengthAwarePaginator::class);
    });

    it('returns the users registered in the database, sorted by role', function () {
        expect(app(UserRepository::class)->list(
            new PaginateParamsDTO(
                column: 'role',
            )
        ))->toBeInstanceOf(LengthAwarePaginator::class);
    });
});

describe('Create new users ', function () {
    it('returns new user created', function () {
        expect(app(UserRepository::class)->create(
            [
                'name' => fake('pt_BR')->name(),
                'email' => fake('pt_BR')->email(),
                'password' => fake('pt_BR')->password(),
                'cpf' => preg_replace('/\D/', '', fake('pt_BR')->cpf()),
                'active' => fake('pt_BR')->randomElement([0, 1]),
                'role_id' => $this->role,
            ]
        ))->toBeInstanceOf(User::class);
    });
});

describe('Query user by ID', function () {
    it('returns user', function () {
        expect(app(UserRepository::class)->getById(
            $this->users->first()->id
        ))->toBeInstanceOf(User::class);
    });

    it('returns error when querying user that does not exist', function () {
        app(UserRepository::class)->getById(
            111111
        );
    })->throws(ModelNotFoundException::class);
});

describe('Updates user data', function () {
    it('returns update user', function () {
        expect(app(UserRepository::class)->update(
            $this->users->first()->id,
            [
                'name' => fake('pt_BR')->name(),
                'email' => fake('pt_BR')->email(),
                'password' => fake('pt_BR')->password(),
                'cpf' => preg_replace('/\D/', '', fake('pt_BR')->cpf()),
                'active' => fake('pt_BR')->randomElement([0, 1]),
                'role_id' => $this->role,
            ]
        ))->toBeInstanceOf(User::class);
    });

    it('returns error when updating a user that does not exist', function () {
        app(UserRepository::class)->update(
            111111,
            [
                'name' => fake('pt_BR')->name(),
                'email' => fake('pt_BR')->email(),
                'password' => fake('pt_BR')->password(),
                'cpf' => fake('pt_BR')->cpf(),
                'active' => fake('pt_BR')->randomElement([0, 1]),
                'role_id' => $this->role,
            ]
        );
    })->throws(ModelNotFoundException::class);
});

describe('Delete a user by ID', function () {
    it('deletes user and returns delete reason', function () {
        $this->actingAs($this->userAuth);
        $user = $this->users->first();
        $reason = 'Test deletion reason';

        $deletedReason = app(UserRepository::class)->delete($user->id, $reason);

        expect($deletedReason)->toBeInstanceOf(DeleteReason::class);
        expect($deletedReason->deleted_user_id)->toBe($user->id);
    });

    it('throws ModelNotFoundException when deleting non-existing user', function () {
        $nonExistingUserId = 111111;
        $reason = 'Test deletion reason';

        expect(function () use ($nonExistingUserId, $reason) {
            app(UserRepository::class)->delete($nonExistingUserId, $reason);
        })->toThrow(ModelNotFoundException::class);
    });
});
