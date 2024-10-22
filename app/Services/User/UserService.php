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

class UserService
{
  public function __construct(
    private UserRepositoryInterface $repository,
    private RoleService $service
  ) {}

  public function index(PaginateParamsDTO $params): LengthAwarePaginator|Collection
  {
    $users = $this->repository->list($params);

    return $users;
  }

  public function create(CreateUserDTO $createUserDto): UserDTO
  {
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

  public function getById(int $id): UserDTO
  {
    $user = $this->repository->getById($id);

    return new UserDTO(...array_merge($user->toArray(), ['roles' => $user->roles->load('permissions')->toArray()]));
  }

  public function update(int $id, UpdateUserDTO $updateUserDTO): UserDTO
  {
    return DB::transaction(function () use ($id, $updateUserDTO) {
      $params = array_filter($updateUserDTO->toArray(), 'strlen');
      $user = $this->repository->update($id, $params);

      !empty($params['notify_status'])
        ? Mail::to($user)->queue(new SendNotificationUserActivation($user))
        : null;
        
      $userData = $user->toArray();
      $userData['roles'] = $user->roles->load('permissions')->toArray();

      return new UserDTO(...$userData);
    });
  }

  public function delete(int $id, string $reason): void
  {
    auth()->id() === $id
      ? throw new BadRequestException('Não é possível realizar essa ação.')
      : DB::transaction(function () use ($id, $reason) {
        tap(
          $this->repository->delete($id, $reason),
          fn($deleteReason) => Mail::to($deleteReason->deleted_user_email)
            ->send(new AccountDeletionNotification($deleteReason->deleted_user_name, $deleteReason->reason))
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
        fn($user) => Mail::to($user)->queue(new SendVerifyEmail($user))
      );
    });
  }

  public function verify(int $id): void
  {
    $this->repository->verify($id);
  }
}
