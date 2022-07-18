<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain;

enum Status: string
{
    case ACTIVE = 'active';
    case BLOCKED = 'blocked';
    case WAIT = 'wait';
}
