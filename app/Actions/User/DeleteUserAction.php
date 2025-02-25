<?php

declare(strict_types = 1);

namespace App\Actions\User;

use App\Actions\User\{AddDeleteReasonAction as AddReason, RemoveUserRoleAction as RemoveRole};
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Fluent;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final readonly class DeleteUserAction
{
    public function execute(Fluent $params, User $user): bool
    {
        return DB::transaction(function () use ($params, $user) {

            throw_if(
                auth()->id() === $user->id,
                BadRequestException::class,
                'Não é possível realizar essa ação.'
            );

            AddReason::make()->execute($user, $params->reason);

            RemoveRole::make()->execute($user);

            return (bool) $user->delete();
        });
    }
}
