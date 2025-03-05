<?php

declare(strict_types = 1);

namespace App\Actions\User;

use App\Mail\SendRandomPassword;
use App\Models\User;
use App\Traits\LogsActivityTrait;
use Illuminate\Support\Facades\{DB, Mail};
use Illuminate\Support\Fluent;
use Spatie\Permission\Models\Role;

final readonly class CreateUserAction
{
    use LogsActivityTrait;

    /**
     * @param Fluent<string, mixed> $params
     */
    public function execute(Fluent $params): User
    {
        return DB::transaction(function () use ($params): User {
            $user = User::create([
                'name' => $params->get('name'),
                'email' => $params->get('email'),
                'password' => $params->get('password'),
                'cpf' => $params->get('cpf'),
                'active' => $params->get('active', false) ? 'true' : 'false',
            ]);

            $user->syncRoles([$params->get('role_id')]);

            if ($params->get('send_random_password', false)) {
                Mail::to($user)->queue(new SendRandomPassword($user, $params->get('password')));
            }

            $this->writeOnLog($user); // TODO: Move to Event or Log

            return $user;
        });
    }

    private function writeOnLog(User $user): void
    {
        /** @var Role|null $role */
        $role = $user->roles()->first();

        $description = sprintf(
            'Criou um novo usuário "%s" com perfil %s',
            $user->name,
            $role->name ?? 'Nenhum perfil associado'
        );

        $this->logGeneralActivity(
            activityName: 'Gestão de Usuários',
            model: $user,
            description: $description,
            event: 'create'
        );
    }

}
