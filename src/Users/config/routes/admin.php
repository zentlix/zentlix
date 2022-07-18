<?php

declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Zentlix\Users\UI\Http\Web\Controller\Admin\SecurityController;

return function (RoutingConfigurator $routes) {
    $routes->add('login', '/sign-in')
        ->controller([SecurityController::class, 'login'])
        ->methods(['GET', 'POST'])
    ;
};
