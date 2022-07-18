<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Zentlix\Users\App\Locale\Domain\Repository\CheckLocaleByCodeInterface;
use Zentlix\Users\App\Locale\Domain\Repository\LocaleRepositoryInterface;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\Repository;
use Zentlix\Users\App\Locale\Infrastructure\Repository\LocaleStore;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->alias(Repository\LocaleRepositoryInterface::class, Repository\DoctrineLocaleRepository::class)

        ->alias(LocaleRepositoryInterface::class, LocaleStore::class)

        ->alias(CheckLocaleByCodeInterface::class, Repository\DoctrineLocaleRepository::class)
    ;
};
