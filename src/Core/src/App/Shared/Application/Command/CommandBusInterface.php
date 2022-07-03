<?php

declare(strict_types=1);

namespace Zentlix\Core\App\Shared\Application\Command;

interface CommandBusInterface
{
    public function handle(CommandInterface $command): void;
}
