<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain\Specification;

use Symfony\Component\Uid\Uuid;
use Zentlix\Users\App\User\Domain\Exception\EmailAlreadyExistException;

interface ExistUserGroupSpecificationInterface
{
    /**
     * @param Uuid|Uuid[] $uuid
     *
     * @throws EmailAlreadyExistException
     */
    public function isExist(array|Uuid $uuid): bool;
}
