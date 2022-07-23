<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Zentlix\Users\App\Locale\Domain\Repository\CheckLocaleByCodeInterface;
use Zentlix\Users\App\User\Domain\Repository\CheckUserGroupByCodeInterface;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->set(
            \Zentlix\Users\App\Locale\Domain\Specification\UniqueCodeSpecificationInterface::class,
            \Zentlix\Users\App\Locale\Infrastructure\Specification\UniqueCodeSpecification::class
        )
            ->args([
                service(CheckLocaleByCodeInterface::class),
            ])

        ->set(
            \Zentlix\Users\App\User\Domain\Specification\UniqueCodeSpecificationInterface::class,
            \Zentlix\Users\App\User\Infrastructure\Specification\UniqueCodeSpecification::class
        )
            ->args([
                service(CheckUserGroupByCodeInterface::class),
            ])
    ;
};
