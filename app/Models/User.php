<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\{HasPermissions, HasRoles};

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $cpf
 * @property int $active
 * @property string|null $email_verified_at
 * @property string $created_at
 * @property string $updated_at
 * @property \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 */
class User extends Authenticatable implements MustVerifyEmail {
    use HasApiTokens;
    use HasFactory;
    use HasPermissions;
    use HasRoles;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf',
        'active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function setCpfAttribute($value) {
        $this->attributes['cpf'] = preg_replace('/\D/', '', $value); // Remove tudo que não for número
    }
}
