<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Zentlix\Users\App\Locale\Domain\Repository\CheckLocaleByCodeInterface;
use Zentlix\Users\App\Locale\Domain\Specification\UniqueCodeSpecificationInterface;
use Zentlix\Users\App\Locale\Infrastructure\Specification\UniqueCodeSpecification;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->set(UniqueCodeSpecificationInterface::class, UniqueCodeSpecification::class)
            ->args([
                service(CheckLocaleByCodeInterface::class),
            ])
    ;
};
