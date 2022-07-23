<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain\Service;

use Zentlix\Users\App\User\Application\Command\CreateUserGroupCommand;
use Zentlix\Users\App\User\Domain\Exception\CodeAlreadyExistException;
use Zentlix\Users\App\User\Domain\Exception\UserGroupValidationException;

interface UserGroupValidatorInterface
{
    /**
     * @throws UserGroupValidationException
     * @throws CodeAlreadyExistException
     */
    public function preCreate(CreateUserGroupCommand $command): void;
}
