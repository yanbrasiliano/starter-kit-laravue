<?php

namespace App\Services\User;

use App\DTO\Paginate\PaginateDataDTO;
use App\DTO\Paginate\PaginateParamsDTO;
use App\DTO\User\CreateUserDTO;
use App\DTO\User\RegisterExternalUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\DTO\User\UserDTO;
use App\Enums\RolesEnum;
use App\Mail\AccountDeletionNotification;
use App\Mail\SendNotificationUserActivation;
use App\Mail\SendRandomPassword;
use App\Mail\SendVerifyEmail;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\RoleService;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private RoleService $roleService
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
        if ($params['send_random_password']) {
            $password = Str::password(8);
            $params['password'] = $password;
        }

        $params['password'] = Hash::make($params['password']);
        $user = $this->repository->create($params);

        if (isset($password)) {
            Mail::to($user)
                ->queue(new SendRandomPassword($user, $password));
        }

        return new UserDTO(
            ...array_merge(
                $user->toArray(),
                ['roles' => $user->roles->toArray()]
            )
        );
    }

    public function getById(int $id): UserDTO
    {
        $user = $this->repository->getById($id);

        return new UserDTO(...array_merge($user->toArray(), ['roles' => $user->roles->toArray()]));
    }

    public function update(int $id, UpdateUserDTO $updateUserDTO): UserDTO
    {
        $params = array_filter($updateUserDTO->toArray(), 'strlen');

        $user = $this->repository->update($id, $params);

        if (isset($params['notify_status']) && $params['notify_status']) {
            Mail::to($user)
                ->queue(new SendNotificationUserActivation($user));
        }

        return new UserDTO(
            ...array_merge(
                $user->toArray(),
                ['roles' => $user->roles->toArray()]
            )
        );
    }

    public function delete(int $id, string $reason): void
    {
        if (auth()->id() == $id) {
            throw new BadRequestException('Não é possível realizar essa ação.');
        }

        $deleteReason = $this->repository->delete($id, $reason);

        Mail::to($deleteReason->deleted_user_email)->send(new AccountDeletionNotification($deleteReason->deleted_user_name, $deleteReason->reason));
    }

    public function updatePassword($id, string $password): void
    {
        $this->repository->updatePassword(
            $id,
            Hash::make($password)
        );
    }

    public function registerExternal(RegisterExternalUserDTO $registerExternalUserDTO): void
    {
        if (
            $this->isEmailUefs($registerExternalUserDTO->email)
            && $registerExternalUserDTO->role == RolesEnum::REVIEWER->value
        ) {
            throw new Exception('O email informado não pode ser utilizado para esse perfil de usuário.');
        }

        $role = $this->roleService->getBySlug($registerExternalUserDTO->role);

        $user = $this->repository->create(
            array_merge(
                ['role_id' => [$role->id]],
                $registerExternalUserDTO->toArray()
            )
        );

        Mail::to($user)->queue(new SendVerifyEmail($user));
    }

    public function verify(int $id): void
    {
        $this->repository->verify($id);
    }

    private function isEmailUefs(string $email): bool
    {
        return str_contains($email, '@uefs');
    }
}
