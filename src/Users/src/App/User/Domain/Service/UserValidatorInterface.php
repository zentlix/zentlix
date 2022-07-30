<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain\Service;

use Zentlix\Users\App\User\Application\Command\CreateUserCommand;

interface UserValidatorInterface
{
    public function preCreate(CreateUserCommand $command): void;
}
