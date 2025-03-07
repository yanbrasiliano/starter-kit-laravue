<?php

declare(strict_types = 1);

namespace App\Actions\User;

use App\Mail\AccountDeletionNotification;
use App\Models\{DeleteReason, User};
use Illuminate\Support\Facades\{DB, Mail};

final readonly class AddDeleteReasonAction
{
    public function execute(User $user, string $reason): void
    {
        DB::transaction(function () use ($user, $reason) {

            /** @var User|null $authenticatedUser */
            $authenticatedUser = auth()->user();

            if (!$authenticatedUser) {
                throw new \RuntimeException('Usuário não autenticado.');
            }

            $deleteReason = DeleteReason::create([
                'deleted_user_id' => $user->id,
                'deleted_user_email' => $user->email,
                'deleted_user_name' => $user->name,
                'deleted_by_user_id' => auth()->id(),
                'deleted_by_user_name' => $authenticatedUser->name,
                'deleted_by_user_email' => $authenticatedUser->email,
                'reason' => $reason,
                'deleted_at' => now(),
            ]);

            $deletedUser = (new User())->forceFill([
                'id' => $deleteReason->deleted_user_id,
                'email' => $deleteReason->deleted_user_email,
                'name' => $deleteReason->deleted_user_name,
            ]);

            Mail::to($deletedUser)->send(new AccountDeletionNotification($deletedUser, $reason));
        });
    }
}
