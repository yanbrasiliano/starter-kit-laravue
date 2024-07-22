<?php

namespace App\Repositories\EloquentRepository;

use App\Models\{DeleteReason, User};
use App\Repositories\AbstractRepository;
use App\Repositories\Contracts\UserRepositoryInterface;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * @property object $roles
 */
class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function list(array $params): LengthAwarePaginator
    {
        return $this->model->query()
          ->select('users.*', 'roles.name as role', 'role_user.role_id as role_id')
          ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
          ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
          ->when(Arr::get($params, 'search'), fn ($query, $search) => $query->where(
              fn ($query) => $query->where('users.id', 'ilike', "%{$search}%")
              ->orWhere('users.name', 'ilike', "%{$search}%")
              ->orWhere('users.email', 'ilike', "%{$search}%")
              ->orWhere('roles.name', 'ilike', "%{$search}%")
          ))
          ->when(Arr::get($params, 'order'), fn ($query, $order) => $query->orderBy(
              match (Arr::get($params, 'column')) {
                  'name' => 'users.name',
                  'email' => 'users.email',
                  'role' => 'roles.name',
                  default => 'users.id',
              },
              $order
          ))
          ->paginate(
              perPage: Arr::get($params, 'limit', 10),
              page: Arr::get($params, 'page', 1)
          );
    }

    public function create(array $params): Model|User
    {
        return DB::transaction(fn () => tap(
            $this->model->create(Arr::only($params, ['name', 'email', 'password', 'cpf', 'active'])),
            fn ($user) => $user->syncRoles([$params['role_id']])
        ));
    }

    public function getById(int $id): Model|User
    {
        return $this->model->with('roles.permissions')->findOrFail($id);
    }

    public function update(int $id, array $params): Model|User
    {
        return DB::transaction(fn () => tap(
            $this->model->findOrFail($id),
            fn ($user) => $user->update($params) && isset($params['role_id']) ? $user->syncRoles([$params['role_id']]) : null
        ));
    }

    public function delete(int $id, string $reason): DeleteReason
    {
        return DB::transaction(function () use ($id, $reason) {
            $user = User::findOrFail($id);

            $deleteReason = new DeleteReason([
                'deleted_user_id' => $user->id,
                'deleted_user_email' => $user->email,
                'deleted_user_name' => $user->name,
                'deleted_by_user_id' => auth()->id(),
                'deleted_by_user_name' => auth()->user()->name,
                'deleted_by_user_email' => auth()->user()->email,
                'reason' => $reason,
                'deleted_at' => now(),
            ]);

            $deleteReason->save();
            $user->delete();

            return $deleteReason;
        });
    }

    public function updatePassword(int $id, string $password): void
    {
        $this->model->findOrFail($id)->update(['password' => $password]);
    }

    public function verify(int $id): void
    {
        tap(
            $this->model::findOrFail($id),
            fn ($user) => $user->hasVerifiedEmail()
            ? throw new Exception('Seu cadastro já foi validado! Por favor, aguarde até que um administrador realize a liberação do seu acesso.', Response::HTTP_CONFLICT)
            : $user->markEmailAsVerified()
        );
    }
}
