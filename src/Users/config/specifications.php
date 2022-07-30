<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Zentlix\Users\App\Locale\Domain\Repository\CheckLocaleByCodeInterface;
use Zentlix\Users\App\Locale\Domain\Specification\UniqueCodeSpecificationInterface as UniqueLocaleCodeInterface;
use Zentlix\Users\App\Locale\Infrastructure\Specification\UniqueCodeSpecification as UniqueLocaleCode;
use Zentlix\Users\App\User\Domain\Repository\CheckUserByEmailInterface;
use Zentlix\Users\App\User\Domain\Repository\CheckUserGroupByCodeInterface;
use Zentlix\Users\App\User\Domain\Repository\CheckUserGroupInterface;
use Zentlix\Users\App\User\Domain\Specification\ExistUserGroupSpecificationInterface;
use Zentlix\Users\App\User\Domain\Specification\UniqueCodeSpecificationInterface as UniqueGroupCodeInterface;
use Zentlix\Users\App\User\Domain\Specification\UniqueEmailSpecificationInterface;
use Zentlix\Users\App\User\Infrastructure\Specification\ExistUserGroupSpecification;
use Zentlix\Users\App\User\Infrastructure\Specification\UniqueCodeSpecification as UniqueGroupCode;
use Zentlix\Users\App\User\Infrastructure\Specification\UniqueEmailSpecification;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->set(UniqueLocaleCodeInterface::class, UniqueLocaleCode::class)
            ->args([
                service(CheckLocaleByCodeInterface::class),
            ])

        ->set(UniqueGroupCodeInterface::class, UniqueGroupCode::class)
            ->args([
                service(CheckUserGroupByCodeInterface::class),
            ])

        ->set(UniqueEmailSpecificationInterface::class, UniqueEmailSpecification::class)
            ->args([
                service(CheckUserByEmailInterface::class),
                service('translator'),
            ])

        ->set(ExistUserGroupSpecificationInterface::class, ExistUserGroupSpecification::class)
            ->args([
                service(CheckUserGroupInterface::class),
                service('translator'),
            ])
    ;
};
