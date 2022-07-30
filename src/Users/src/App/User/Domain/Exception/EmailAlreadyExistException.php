<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain\Exception;

final class EmailAlreadyExistException extends \InvalidArgumentException
{
    public function __construct($message = 'The user with this Email already exists.')
    {
        parent::__construct($message);
    }
}
