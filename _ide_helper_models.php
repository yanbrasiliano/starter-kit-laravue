<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */

namespace App\Models{
    /**
     *
     *
     * @property int $id
     * @property int $deleted_user_id
     * @property string $deleted_user_email
     * @property string $deleted_user_name
     * @property int|null $deleted_by_user_id
     * @property string $deleted_by_user_name
     * @property string $deleted_by_user_email
     * @property string $reason
     * @property string $deleted_at
     * @property-read \App\Models\User|null $deletedByUser
     * @method static \Database\Factories\DeleteReasonFactory factory($count = null, $state = [])
     * @method static \Illuminate\Database\Eloquent\Builder<static>|DeleteReason newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|DeleteReason newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|DeleteReason query()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|DeleteReason whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|DeleteReason whereDeletedByUserEmail($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|DeleteReason whereDeletedByUserId($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|DeleteReason whereDeletedByUserName($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|DeleteReason whereDeletedUserEmail($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|DeleteReason whereDeletedUserId($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|DeleteReason whereDeletedUserName($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|DeleteReason whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|DeleteReason whereReason($value)
     */
    class DeleteReason extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     *
     *
     * @property int $id
     * @property string $name
     * @property string $email
     * @property string|null $cpf
     * @property int $active
     * @property string|null $email_verified_at
     * @property string $created_at
     * @property string $updated_at
     * @property \Illuminate\Database\Eloquent\Collection $roles
     * @property string $password
     * @property string|null $remember_token
     * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
     * @property-read int|null $notifications_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
     * @property-read int|null $permissions_count
     * @property-read int|null $roles_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
     * @property-read int|null $tokens_count
     * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereActive($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCpf($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
     * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
     */
    class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail
    {
    }
}
