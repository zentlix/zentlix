<?php

declare(strict_types=1);

namespace Zentlix\Users;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class UsersBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
