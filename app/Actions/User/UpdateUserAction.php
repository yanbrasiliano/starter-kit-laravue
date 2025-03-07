<?php

declare(strict_types = 1);

namespace App\Actions\User;

use App\Models\User;
use App\Traits\LogsActivityTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Fluent;

final readonly class UpdateUserAction
{
    use LogsActivityTrait;

    /**
     * @param Fluent<string, mixed> $params
     */
    public function execute(Fluent $params, int|string $id): User
    {
        return DB::transaction(function () use ($id, $params): User {
            /** @var User $user */
            $user = User::findOrFail($id);

            $fillableParams = array_intersect_key(
                $params->toArray(),
                array_flip($user->getFillable())
            );

            $user->update($fillableParams);
            $user->syncRoles([$params->get('role_id')]);

            $this->logUpdateActivity('Gestão de Perfis', $user, $user->getDirty(), 'Atualizou um perfil');

            return $user->load('roles');
        });
    }
}
