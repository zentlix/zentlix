<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Zentlix\Users\App\Locale\Domain\Repository\CheckLocaleByCodeInterface;
use Zentlix\Users\App\Locale\Domain\Repository\LocaleRepositoryInterface;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\Repository\DoctrineLocaleRepository;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\Repository\LocaleRepositoryInterface as ReadLocaleRepository;
use Zentlix\Users\App\Locale\Infrastructure\Repository\LocaleStore;
use Zentlix\Users\App\User\Domain\Repository\CheckUserByEmailInterface;
use Zentlix\Users\App\User\Domain\Repository\CheckUserGroupByCodeInterface;
use Zentlix\Users\App\User\Domain\Repository\CheckUserGroupInterface;
use Zentlix\Users\App\User\Domain\Repository\UserGroupRepositoryInterface;
use Zentlix\Users\App\User\Domain\Repository\UserRepositoryInterface;
use Zentlix\Users\App\User\Infrastructure\ReadModel\Repository\DoctrineUserGroupRepository;
use Zentlix\Users\App\User\Infrastructure\ReadModel\Repository\DoctrineUserRepository;
use Zentlix\Users\App\User\Infrastructure\ReadModel\Repository\UserGroupRepositoryInterface as ReadUserGroupRepository;
use Zentlix\Users\App\User\Infrastructure\ReadModel\Repository\UserRepositoryInterface as ReadUserRepository;
use Zentlix\Users\App\User\Infrastructure\Repository\UserGroupStore;
use Zentlix\Users\App\User\Infrastructure\Repository\UserStore;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->alias(ReadLocaleRepository::class, DoctrineLocaleRepository::class)
        ->alias(LocaleRepositoryInterface::class, LocaleStore::class)
        ->alias(CheckLocaleByCodeInterface::class, DoctrineLocaleRepository::class)

        ->alias(ReadUserGroupRepository::class, DoctrineUserGroupRepository::class)
        ->alias(UserGroupRepositoryInterface::class, UserGroupStore::class)
        ->alias(CheckUserGroupByCodeInterface::class, DoctrineUserGroupRepository::class)
        ->alias(CheckUserGroupInterface::class, DoctrineUserGroupRepository::class)

        ->alias(ReadUserRepository::class, DoctrineUserRepository::class)
        ->alias(UserRepositoryInterface::class, UserStore::class)
        ->alias(CheckUserByEmailInterface::class, DoctrineUserRepository::class)
    ;
};
