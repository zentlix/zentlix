<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Zentlix\Core\App\Shared\Application\Command\CommandBusInterface;
use Zentlix\Core\App\Shared\Application\Command\CommandHandlerInterface;
use Zentlix\Core\App\Shared\Infrastructure\Bus\Command\MessengerCommandBus;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->instanceof(CommandHandlerInterface::class)
            ->tag('messenger.message_handler', ['bus' => 'messenger.bus.command'])

        ->alias(CommandBusInterface::class, MessengerCommandBus::class)
    ;
};
