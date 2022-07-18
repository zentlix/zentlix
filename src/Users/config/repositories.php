<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Broadway\EventStore\EventStore;
use Doctrine\ORM\EntityManagerInterface;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\Repository\DoctrineLocaleRepository;
use Zentlix\Users\App\Locale\Infrastructure\Repository\LocaleStore;
use Zentlix\Users\App\User\Infrastructure\ReadModel\Repository\DoctrineUserRepository;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->set(DoctrineLocaleRepository::class)
            ->args([
                service(EntityManagerInterface::class),
                service('knp_paginator'),
            ])

        ->set(LocaleStore::class)
            ->args([
                service(EventStore::class),
                service('broadway.event_handling.event_bus'),
            ])

        ->set(DoctrineUserRepository::class)
            ->args([
                service(EntityManagerInterface::class),
                service('knp_paginator'),
            ])
    ;
};
