<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Broadway\EventStore\EventStore;
use Doctrine\ORM\EntityManagerInterface;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->set(
            \Zentlix\Users\App\Locale\Infrastructure\ReadModel\Repository\LocaleRepositoryInterface::class,
            \Zentlix\Users\App\Locale\Infrastructure\ReadModel\Repository\DoctrineLocaleRepository::class
        )
            ->args([
                service(EntityManagerInterface::class),
                service('knp_paginator'),
            ])

        ->set(
            \Zentlix\Users\App\Locale\Domain\Repository\LocaleRepositoryInterface::class,
            \Zentlix\Users\App\Locale\Infrastructure\Repository\LocaleStore::class
        )
            ->args([
                service(EventStore::class),
                service('broadway.event_handling.event_bus'),
            ])

        ->alias(
            \Zentlix\Users\App\Locale\Domain\Repository\CheckLocaleByCodeInterface::class,
            \Zentlix\Users\App\Locale\Infrastructure\ReadModel\Repository\LocaleRepositoryInterface::class
        )
    ;
};
