<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Zentlix\Users\UI\Http\Web\Controller\SecurityController;

return function (RoutingConfigurator $routes) {
    $routes->add('logout', '/logout')
        ->controller([SecurityController::class, 'logout'])
    ;
};
