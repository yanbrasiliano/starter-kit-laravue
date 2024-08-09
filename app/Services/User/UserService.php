<?php

namespace App\Services\User;

use App\DTO\Paginate\{PaginateDataDTO, PaginateParamsDTO};
use App\DTO\User\{CreateUserDTO, RegisterExternalUserDTO, UpdateUserDTO, UserDTO};
use App\Mail\{AccountDeletionNotification, SendNotificationUserActivation, SendRandomPassword, SendVerifyEmail};
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Role\RoleService;
use Illuminate\Support\Facades\{Hash, Mail};
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private RoleService $service
    ) {
    }

    public function index(PaginateParamsDTO $params): PaginateDataDTO
    {
        $users = $this->repository->list($params->toArray());

        return new PaginateDataDTO(...collect($users)->toArray());
    }

    public function create(CreateUserDTO $createUserDto): UserDTO
    {
        $params = $createUserDto->toArray();
        $password = $params['send_random_password'] ? Str::password(8) : null;
        $params['password'] = Hash::make($password ?? $params['password']);

        $user = tap(
            $this->repository->create($params),
            fn ($user) => $password ? Mail::to($user)->queue(new SendRandomPassword($user, $password)) : null
        );

        $userData = array_merge($user->toArray(), ['roles' => $user->roles->load('permissions')->toArray()]);

        return new UserDTO(...$userData);
    }

    public function getById(int $id): UserDTO
    {
        $user = $this->repository->getById($id);

        return new UserDTO(...array_merge($user->toArray(), ['roles' => $user->roles->load('permissions')->toArray()]));
    }

    public function update(int $id, UpdateUserDTO $updateUserDTO): UserDTO
    {
        $params = array_filter($updateUserDTO->toArray(), 'strlen');

        $user = tap(
            $this->repository->update($id, $params),
            fn ($user) => ($params['notify_status'] ?? false) ? Mail::to($user)->queue(new SendNotificationUserActivation($user)) : null
        );

        $userData = $user->toArray();
        $userData['roles'] = $user->roles->load('permissions')->toArray();

        return new UserDTO(...$userData);
    }

    public function delete(int $id, string $reason): void
    {
        auth()->id() === $id
          ? throw new BadRequestException('Não é possível realizar essa ação.')
          : tap(
              $this->repository->delete($id, $reason),
              fn ($deleteReason) => Mail::to($deleteReason->deleted_user_email)
              ->send(new AccountDeletionNotification($deleteReason->deleted_user_name, $deleteReason->reason))
          );
    }

    public function updatePassword(int $id, string $password): void
    {
        $this->repository->updatePassword($id, Hash::make($password));
    }

    public function registerExternal(RegisterExternalUserDTO $registerExternalUserDTO): void
    {
        $role = $this->service->getBySlug($registerExternalUserDTO->role);

        tap(
            $this->repository->create(array_merge(['role_id' => [$role->id]], $registerExternalUserDTO->toArray())),
            fn ($user) => Mail::to($user)->queue(new SendVerifyEmail($user))
        );
    }

    public function verify(int $id): void
    {
        $this->repository->verify($id);
    }
}
