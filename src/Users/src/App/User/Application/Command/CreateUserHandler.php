<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Application\Command;

use Zentlix\Core\App\Shared\Application\Command\CommandHandlerInterface;

final class CreateUserHandler implements CommandHandlerInterface
{
    public function __construct(
    ) {
    }

    public function __invoke(CreateUserCommand $command): void
    {
    }
}
