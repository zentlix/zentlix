<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Zentlix\Users\App\Locale\Domain\Repository\CheckLocaleByCodeInterface;
use Zentlix\Users\App\Locale\Domain\Repository\LocaleRepositoryInterface;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\Repository\DoctrineLocaleRepository;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\Repository\LocaleRepositoryInterface as ReadLocaleRepository;
use Zentlix\Users\App\Locale\Infrastructure\Repository\LocaleStore;
use Zentlix\Users\App\User\Domain\Repository\CheckUserGroupByCodeInterface;
use Zentlix\Users\App\User\Domain\Repository\UserGroupRepositoryInterface;
use Zentlix\Users\App\User\Infrastructure\ReadModel\Repository\DoctrineUserGroupRepository;
use Zentlix\Users\App\User\Infrastructure\ReadModel\Repository\UserGroupRepositoryInterface as ReadUserGroupRepository;
use Zentlix\Users\App\User\Infrastructure\Repository\UserGroupStore;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->alias(ReadLocaleRepository::class, DoctrineLocaleRepository::class)
        ->alias(LocaleRepositoryInterface::class, LocaleStore::class)
        ->alias(CheckLocaleByCodeInterface::class, DoctrineLocaleRepository::class)

        ->alias(ReadUserGroupRepository::class, DoctrineUserGroupRepository::class)
        ->alias(UserGroupRepositoryInterface::class, UserGroupStore::class)
        ->alias(CheckUserGroupByCodeInterface::class, DoctrineUserGroupRepository::class)
    ;
};
