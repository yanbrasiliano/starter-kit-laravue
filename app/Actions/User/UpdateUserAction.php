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

    public function execute(Fluent $params, User $user): ?User
    {
        return DB::transaction(function () use ($user, $params) {
            $fillableParams = array_intersect_key(
                $params->toArray(),
                array_flip($user->getFillable())
            );

            $user->fill($fillableParams);
            $user->save();
            $user->syncRoles([$params->role_id]);

            $this->logUpdateActivity('Gestão de Perfis', $user, $user->getDirty(), 'Atualizou um perfil');

            return $user->load('roles');
        });
    }

}
