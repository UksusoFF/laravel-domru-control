<?php

declare(strict_types=1);

namespace App\Models;

enum AccountStep: string
{
    case INIT = 'init';
    case CODE = 'code';
    case EDIT = 'edit';
}
