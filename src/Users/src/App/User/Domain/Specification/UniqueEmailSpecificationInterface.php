<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain\Specification;

use Zentlix\Users\App\User\Domain\Exception\EmailAlreadyExistException;
use Zentlix\Users\App\User\Domain\ValueObject\Email;

interface UniqueEmailSpecificationInterface
{
    /**
     * @throws EmailAlreadyExistException
     */
    public function isUnique(Email $email): bool;
}
