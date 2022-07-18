<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Zentlix\Core\UI\Http\Web\Controller\Admin\DashboardController;

return function (RoutingConfigurator $routes) {
    $routes->add('dashboard', '/')
        ->controller(DashboardController::class)
        ->methods(['GET'])
    ;
};
