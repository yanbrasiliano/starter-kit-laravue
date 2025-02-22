<?php

declare(strict_types = 1);

namespace App\Actions\User;

use App\Actions\Role\RoleBySlugAction;
use App\Mail\{SendVerifyEmail};
use App\Models\User;
use App\Traits\LogsActivityTrait;
use Illuminate\Support\Facades\{DB, Mail};
use Illuminate\Support\Fluent;

final readonly class CreateExternalUserAction
{
    use LogsActivityTrait;
    /**
     * @param \Illuminate\Support\Fluent&object{
     *     name: string,
     *     email: string,
     *     password: string,
     *     cpf: string,
     *     active: bool,
     *     role: string
     * } $params
     * @return \App\Models\User
     */
    public function execute(Fluent $params): ?User
    {
        return DB::transaction(function () use ($params) {
            $user = User::create([
                'name' => $params->name,
                'email' => $params->email,
                'password' => $params->password,
                'cpf' => $params->cpf,
                'active' => $params->active ? 'true' : 'false',
            ]);

            $role = RoleBySlugAction::make()->execute($params->role);

            $user->syncRoles([$role->id]);

            $this->writeOnLog($user); // TODO: Move to Event or Log

            Mail::to($user)->queue(new SendVerifyEmail($user));

            return $user;
        });
    }

    private function writeOnLog(User $user): void
    {
        $this->logGeneralActivity(
            activityName: 'Gestão de Usuários',
            model: $user,
            description: sprintf(
                'Criou um novo usuário "%s" com %d permissões',
                $user->email,
                $user->roles()->first()->permissions()->count()
            ),
            event: 'create'
        );
    }
}
