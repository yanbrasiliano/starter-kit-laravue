<?php

namespace App\Repositories\EloquentRepository;

use App\DTO\Paginate\PaginateParamsDTO;
use App\Models\{DeleteReason, User};
use App\Repositories\AbstractRepository;
use App\Repositories\Contracts\UserRepositoryInterface;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\{Collection, Model};
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

/**
 * @property object $roles
 */
class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function __construct(protected User $user)
    {
        $this->model = $user;
    }

    public function list(PaginateParamsDTO $paramsDTO): LengthAwarePaginator|Collection
    {
        $query = $this->model->newQuery();

        $query->select([
            'users.*',
            'roles.name as role',
            'role_user.role_id as role_id',
        ])
            ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
            ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id');

        $query->when($paramsDTO->search, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('users.id', 'ilike', "%$search%")
                    ->orWhere('users.name', 'ilike', "%$search%")
                    ->orWhere('users.email', 'ilike', "%$search%")
                    ->orWhere('roles.name', 'ilike', "%$search%");
            });
        });

        $query->when($paramsDTO->order, function ($query, $order) use ($paramsDTO) {
            $column = match ($paramsDTO->column) {
                'name' => 'users.name',
                'email' => 'users.email',
                'role' => 'roles.name',
                'setSituation' => 'users.active',
                default => 'users.id',
            };
            $query->orderBy($column, $order);
        });

        return $paramsDTO->paginated ? $query->paginate($paramsDTO->limit ?? 10) : $query->get();
    }

    public function create(array $params): User
    {
        return tap(
            $this->model->create(Arr::only($params, ['name', 'email', 'password', 'cpf', 'active'])),
            fn(User $user) => $user->syncRoles([$params['role_id']])
        );
    }


    /**
     * @param int $id
     * @return \App\Models\User
     */
    public function getById(int $id): Model|User
    {
        return $this->model->with('roles.permissions')->findOrFail($id);
    }

    public function update(int $id, array $params): Model|User
    {
        return tap($this->model->findOrFail($id), function ($user) use ($params) {
            $user->update($params);
            isset($params['role_id']) ? $user->syncRoles([$params['role_id']]) : null;
        });
    }
    public function delete(int $id, string $reason): DeleteReason
    {
        /** @var \App\Models\User $user */
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
    }

    public function updatePassword(int $id, string $password): void
    {
        $this->model->findOrFail($id)->update(['password' => $password]);
    }

    public function verify(int $id): void
    {
        tap(
            $this->model::findOrFail($id),
            fn($user) => $user->hasVerifiedEmail()
            ? throw new Exception('Seu cadastro já foi validado! Por favor, aguarde até que um administrador realize a liberação do seu acesso.', Response::HTTP_CONFLICT)
            : $user->markEmailAsVerified()
        );
    }
}
