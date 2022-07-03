<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Broadway\EventStore\EventStore;
use Doctrine\ORM\EntityManagerInterface;
use Zentlix\Users\App\Locale\Domain\Repository\CheckLocaleByCodeInterface;
use Zentlix\Users\App\Locale\Domain\Repository\LocaleRepositoryInterface;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\Repository\DoctrineLocaleRepository;
use Zentlix\Users\App\Locale\Infrastructure\Repository\LocaleStore;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->set(DoctrineLocaleRepository::class)
            ->args([
                service(EntityManagerInterface::class),
            ])

        ->set(LocaleRepositoryInterface::class, LocaleStore::class)
            ->args([
                service(EventStore::class),
                service('broadway.event_handling.event_bus'),
            ])

        ->alias(CheckLocaleByCodeInterface::class, DoctrineLocaleRepository::class)
    ;
};
