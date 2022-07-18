<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Application\Command;

use Zentlix\Core\App\Shared\Application\Command\CommandInterface;

final class SignInCommand implements CommandInterface
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {
    }
}
