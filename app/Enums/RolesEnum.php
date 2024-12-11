<?php

namespace App\Enums;

enum RolesEnum: string
{
    case ADMINISTRATOR = 'administrator';
    case REVIEWER = 'reviewer';
    case GUEST = 'guest';
}
