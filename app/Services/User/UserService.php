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

class UserService {
    public function __construct(
        private UserRepositoryInterface $repository,
        private RoleService $service
    ) {
    }

    public function index(PaginateParamsDTO $params): LengthAwarePaginator|Collection {
        return $this->repository->list($params);
    }

    public function create(CreateUserDTO $createUserDto): UserDTO {
        return DB::transaction(function () use ($createUserDto) {
            $params = $createUserDto->toArray();
            $password = $params['send_random_password'] ? Str::password(8) : null;
            $params['password'] = Hash::make($password ?? $params['password']);

            $user = tap(
                $this->repository->create($params),
                fn($user) => $password ? Mail::to($user)->queue(new SendRandomPassword($user, $password)) : null
            );

            $userData = array_merge($user->toArray(), ['roles' => $user->roles->load('permissions')->toArray()]);

            return new UserDTO(...$userData);
        });
    }

    public function getById(int $id): UserDTO {
        $user = $this->repository->getById($id);

        return new UserDTO(...array_merge($user->toArray(), ['roles' => $user->roles->load('permissions')->toArray()]));
    }

    public function getModelAndDTOById(int $id): array {
        $user = $this->repository->getById($id);
        $userData = $user->toArray();
        $userData['roles'] = $user->roles->toArray();

        $userDTO = new UserDTO(
            $userData['id'],
            $userData['name'],
            $userData['email'],
            $userData['cpf'] ?? null,
            $userData['active'] ?? 0,
            $userData['email_verified_at'] ?? '',
            $userData['created_at'] ?? '',
            $userData['updated_at'] ?? '',
            $userData['roles'] ?? []
        );

        return [$user, $userDTO];
    }

    public function update(int $id, UpdateUserDTO $updateUserDTO): UserDTO {
        return DB::transaction(function () use ($id, $updateUserDTO) {
            $params = array_filter(get_object_vars($updateUserDTO), fn($value) => !is_null($value));

            $user = $this->repository->update($id, $params);

            if ($updateUserDTO->notify_status) {
                Mail::to($user)->queue(new SendNotificationUserActivation($user));
            }

            return new UserDTO(
                ...$user->only(['id', 'name', 'email', 'cpf', 'active', 'email_verified_at', 'created_at', 'updated_at']),
                ...['roles' => $user->roles->load('permissions')->toArray()]
            );
        });
    }
    public function delete(int $id, string $reason): void {
        throw_if(
            auth()->id() === $id,
            BadRequestException::class,
            'Não é possível realizar essa ação.'
        );

        DB::transaction(function () use ($id, $reason) {
            tap(
                $this->repository->delete($id, $reason),
                fn($deleteReason) => Mail::to(new User([
                    'id' => $deleteReason->deleted_user_id,
                    'email' => $deleteReason->deleted_user_email,
                    'name' => $deleteReason->deleted_user_name,
                ]))->send(new AccountDeletionNotification(
                    new User([
                        'id' => $deleteReason->deleted_user_id,
                        'email' => $deleteReason->deleted_user_email,
                        'name' => $deleteReason->deleted_user_name,
                    ]),
                    $reason
                ))
            );
        });
    }


    public function updatePassword(int $id, string $password): void {
        $this->repository->updatePassword($id, Hash::make($password));
    }

    public function registerExternal(RegisterExternalUserDTO $registerExternalUserDTO): void {
        DB::transaction(function () use ($registerExternalUserDTO) {
            $role = $this->service->getBySlug($registerExternalUserDTO->role);

            tap(
                $this->repository->create(array_merge(['role_id' => [$role->id]], $registerExternalUserDTO->toArray())),
                fn($user) => Mail::to($user)->queue(new SendVerifyEmail($user))
            );
        });
    }

    public function verify(int $id): void {
        $this->repository->verify($id);
    }
}
