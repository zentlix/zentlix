<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain\Exception;

use Doctrine\ORM\EntityNotFoundException;

final class UserGroupIsNotExistException extends EntityNotFoundException
{
}
