<?php

namespace App\Enums;

enum RolesEnum: string
{
    case ADMINISTRATOR = 'administrator';
    case REVIEWER = 'parecerista';
    case GUEST = 'convidado';
}
