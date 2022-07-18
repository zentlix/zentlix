<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Application\Command;

use Zentlix\Core\App\Shared\Application\Command\CommandHandlerInterface;

final class UpdateGroupHandler implements CommandHandlerInterface
{
    public function __construct(
    ) {
    }

    public function __invoke(UpdateGroupCommand $command): void
    {
    }
}
