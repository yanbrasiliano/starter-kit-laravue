<?php

declare(strict_types = 1);

namespace App\Enums;

enum RolesEnum: string
{
    case ADMINISTRATOR = 'administrator';
    case REVIEWER = 'reviewer';
    case GUEST = 'guest';
}
