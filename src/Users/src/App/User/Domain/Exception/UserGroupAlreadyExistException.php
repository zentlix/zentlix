<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain\Exception;

class UserGroupAlreadyExistException extends \InvalidArgumentException
{
    public function __construct(string $message = 'User group already exists.')
    {
        parent::__construct($message);
    }
}
