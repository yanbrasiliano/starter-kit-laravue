<?php

namespace App\Services\User;

use App\DTO\Paginate\{PaginateParamsDTO};
use App\DTO\User\{CreateUserDTO, RegisterExternalUserDTO, UpdateUserDTO, UserDTO};
use App\Mail\{AccountDeletionNotification, SendNotificationUserActivation, SendRandomPassword, SendVerifyEmail};
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Role\RoleService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\{Hash, Mail, DB};
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use App\Models\User;


class UserService
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private RoleService $service
    ) {
    }

    /**
     * @param PaginateParamsDTO $params
     * @return LengthAwarePaginator<User>|Collection<int, User>
     */
    public function index(PaginateParamsDTO $params): LengthAwarePaginator|Collection
    {
        return $this->repository->list($params);
    }

    /**
     * @param CreateUserDTO $createUserDto
     * @return UserDTO
     */
    public function create(CreateUserDTO $createUserDto): UserDTO
    {
        return DB::transaction(function () use ($createUserDto) {
            $params = $createUserDto->toArray();
            $password = $params['send_random_password'] ? Str::password(8) : null;
            $params['password'] = Hash::make(
                $password !== null ? $password : (is_string($params['password']) ? $params['password'] : '')
            );


            /** @var User $user */
            $user = tap(
                $this->repository->create($params),
                fn(User $createdUser) => $password ? Mail::to($createdUser)->queue(new SendRandomPassword($createdUser, $password)) : null
            );

            $userData = array_merge(
                $user->toArray(),
                ['roles' => $user->roles->load('permissions')->toArray()]
            );

            $userData['id'] = (int) $userData['id'];

            return new UserDTO(...$userData);
        });
    }

    public function getById(int $id): UserDTO
    {
        $user = $this->repository->getById($id);

        return new UserDTO(...array_merge($user->toArray(), ['roles' => $user->roles->load('permissions')->toArray()]));
    }

    /**
     * @param int $id
     * @return array{0: \App\Models\User, 1: \App\DTO\User\UserDTO}
     */
    public function getModelAndDTOById(int $id): array
    {
        /** @var \App\Models\User $user */
        $user = $this->repository->getById($id);

        $userData = $user->toArray();
        $userData['roles'] = $user->roles->toArray();

        $userDTO = new UserDTO(
            id: isset($userData['id']) && is_numeric($userData['id']) ? (int) $userData['id'] : 0,
            name: isset($userData['name']) ? (string) $userData['name'] : '',
            email: isset($userData['email']) ? (string) $userData['email'] : '',
            cpf: isset($userData['cpf']) ? (string) $userData['cpf'] : null,
            active: isset($userData['active']) && is_numeric($userData['active']) ? (int) $userData['active'] : 0,
            email_verified_at: isset($userData['email_verified_at']) ? (string) $userData['email_verified_at'] : null,
            created_at: isset($userData['created_at']) ? (string) $userData['created_at'] : '',
            updated_at: isset($userData['updated_at']) ? (string) $userData['updated_at'] : '',
            roles: isset($userData['roles']) ? (array) $userData['roles'] : []
        );

        return [$user, $userDTO];
    }
    public function update(int $id, UpdateUserDTO $updateUserDTO): UserDTO
    {
        return DB::transaction(function () use ($id, $updateUserDTO) {
            $params = array_filter(get_object_vars($updateUserDTO), fn($value) => !is_null($value));

            $user = $this->repository->update($id, $params);

            if ($updateUserDTO->notify_status) {
                Mail::to($user)->queue(new SendNotificationUserActivation($user));
            }

            return new UserDTO(
                id: $user->id,
                name: $user->name,
                email: $user->email,
                cpf: $user->cpf,
                active: $user->active,
                email_verified_at: $user->email_verified_at,
                created_at: $user->created_at,
                updated_at: $user->updated_at,
                roles: $user->roles->load('permissions')->toArray()
            );
        });
    }
    public function delete(int $id, string $reason): void
    {
        throw_if(
            auth()->id() === $id,
            BadRequestException::class,
            'Não é possível realizar essa ação.'
        );

        DB::transaction(function () use ($id, $reason) {
            tap(
                $this->repository->delete($id, $reason),
                fn($deleteReason) => Mail::to($deleteReason->deleted_user_email)
                    ->send(new AccountDeletionNotification($deleteReason->deleted_user_name, $reason))
            );
        });
    }
    public function updatePassword(int $id, string $password): void
    {
        $this->repository->updatePassword($id, Hash::make($password));
    }
    public function registerExternal(RegisterExternalUserDTO $registerExternalUserDTO): void
    {
        DB::transaction(function () use ($registerExternalUserDTO) {
            $role = $this->service->getBySlug($registerExternalUserDTO->role);

            tap(
                $this->repository->create(array_merge(['role_id' => [$role->id]], $registerExternalUserDTO->toArray())),
                fn(User $user) => Mail::to($user)->queue(new SendVerifyEmail($user))
            );
        });
    }


    public function verify(int $id): void
    {
        $this->repository->verify($id);
    }
}
