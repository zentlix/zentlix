<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Zentlix\Users\UI\Http\Rest\Controller\LocaleController;

return function (RoutingConfigurator $routes) {
    $routes->add('locales', '/locales')
        ->controller([LocaleController::class, 'list'])
        ->methods(['GET'])
    ;
};
