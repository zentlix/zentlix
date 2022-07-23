<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain\Exception;

final class CodeAlreadyExistException extends UserGroupAlreadyExistException
{
    public function __construct(string $code)
    {
        parent::__construct(sprintf('User group with symbol code `%s` already exists.', $code));
    }
}
