<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain\Repository;

use Symfony\Component\Uid\Uuid;
use Zentlix\Users\App\User\Domain\ValueObject\Email;

interface CheckUserByEmailInterface
{
    public function existsEmail(Email $email): ?Uuid;
}
