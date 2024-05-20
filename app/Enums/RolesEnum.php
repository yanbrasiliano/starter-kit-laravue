<?php

namespace App\Enums;

enum RolesEnum: string
{
    case ADMINISTRATOR = 'administrator';
    case REVIEWER = 'visitor';
    case GUEST = 'convidado';
}
