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
        $query = $this->model->newQuery();

        $query->select('users.*', 'roles.name as role', 'role_user.role_id as role_id')
          ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
          ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id');

        $query->when(Arr::get($params, 'search'), function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('users.id', 'ilike', "%{$search}%")
                  ->orWhere('users.name', 'ilike', "%{$search}%")
                  ->orWhere('users.email', 'ilike', "%{$search}%")
                  ->orWhere('roles.name', 'ilike', "%{$search}%");
            });
        });

        $query->when(Arr::get($params, 'order'), function ($query, $order) use ($params) {
            $column = match (Arr::get($params, 'column')) {
                'name' => 'users.name',
                'email' => 'users.email',
                'role' => 'roles.name',
                default => 'users.id',
            };

            $query->orderBy($column, $order);
        });

        return $query->paginate(
            perPage: Arr::get($params, 'limit', 10),
            page: Arr::get($params, 'page', 1)
        );
    }

    public function create(array $params): Model|User
    {
        return DB::transaction(function () use ($params) {
            $user = $this->model->create([
                'name' => $params['name'],
                'email' => $params['email'],
                'password' => $params['password'],
                'cpf' => $params['cpf'],
                'active' => $params['active'],
            ]);

            $user->syncRoles([$params['role_id']]);

            return $user;
        });
    }

    public function getById(int $id): Model|User
    {
        return $this->model->findOrFail($id);
    }

    public function update(int $id, array $params): Model|User
    {
        return DB::transaction(function () use ($id, $params) {
            $user = $this->model->findOrFail($id);
            $user->update($params);

            if (isset($params['role_id'])) {
                $user->syncRoles([$params['role_id']]);
            }

            return $user;
        });
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
        $user = $this->model->findOrFail($id);
        $user->update([
            'password' => $password,
        ]);
    }

    public function verify(int $id): void
    {
        $user = $this->model::findOrFail($id);

        if ($user->hasVerifiedEmail()) {
            throw new Exception(
                'Seu cadastro já foi validado! Por favor, aguarde até que um administrador realize a liberação do seu acesso.',
                Response::HTTP_CONFLICT
            );
        }

        $user->markEmailAsVerified();
    }
}
