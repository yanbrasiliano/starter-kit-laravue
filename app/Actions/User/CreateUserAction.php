<?php

declare(strict_types = 1);

namespace App\Actions\User;

use App\Mail\SendRandomPassword;
use App\Models\User;
use App\Traits\LogsActivityTrait;
use Illuminate\Support\Facades\{DB, Mail};
use Illuminate\Support\Fluent;

final readonly class CreateUserAction
{
    use LogsActivityTrait;
    /**
     * @param \Illuminate\Support\Fluent&object{
     *     name: string,
     *     guard: string,
     *     description: string,
     *     slug: string,
     *     permissions: array
     * } $params
     * @return \App\Models\User|null
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

            $user->syncRoles([$params->role_id]);

            if ($params->send_random_password) {
                Mail::to($user)->queue(new SendRandomPassword($user, $params->password));
            }

            $this->writeOnLog($user); // TODO: Move to Event or Log

            return $user;
        });
    }

    private function writeOnLog(User $user): void
    {
        $description = sprintf(
            'Criou um novo usuário "%s" com perfil %d',
            $user->name,
            $user->roles->first()->name
        );

        $this->logGeneralActivity(
            activityName: 'Gestão de Usuários',
            model: $user,
            description: $description,
            event: 'create'
        );
    }
}
