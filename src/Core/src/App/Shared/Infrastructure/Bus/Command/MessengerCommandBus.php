<?php

declare(strict_types=1);

namespace Zentlix\Core\App\Shared\Infrastructure\Bus\Command;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Zentlix\Core\App\Shared\Application\Command\CommandBusInterface;
use Zentlix\Core\App\Shared\Application\Command\CommandInterface;
use Zentlix\Core\App\Shared\Infrastructure\Bus\MessageBusExceptionTrait;

final class MessengerCommandBus implements CommandBusInterface
{
    use MessageBusExceptionTrait;

    public function __construct(
        private readonly MessageBusInterface $messageBus
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function handle(CommandInterface $command): void
    {
        try {
            $this->messageBus->dispatch($command);
        } catch (HandlerFailedException $e) {
            $this->throwException($e);
        }
    }
}
