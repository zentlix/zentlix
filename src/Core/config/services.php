<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Broadway\EventHandling\EventListener;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use Zentlix\Core\App\Shared\Application\Command\CommandBusInterface;
use Zentlix\Core\App\Shared\Application\Query\QueryBusInterface;
use Zentlix\Core\App\Shared\Infrastructure\Bus\Command\MessengerCommandBus;
use Zentlix\Core\App\Shared\Infrastructure\Bus\Query\MessengerQueryBus;
use Zentlix\Core\App\Shared\Infrastructure\Persistence\Doctrine\MigrationsFactory\ContainerAwareFactory;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->instanceof(EventListener::class)
            ->tag('broadway.domain.event_listener')

        ->set(ContainerAwareFactory::class)
            ->args([
                service(Connection::class),
                service(LoggerInterface::class),
                service('service_container'),
            ])

        ->set(MessengerCommandBus::class)
            ->args([
                service('messenger.bus.command'),
            ])

        ->alias(CommandBusInterface::class, MessengerCommandBus::class)

        ->set(MessengerQueryBus::class)
            ->args([
                service('messenger.bus.query'),
            ])

        ->alias(QueryBusInterface::class, MessengerQueryBus::class)
    ;
};
