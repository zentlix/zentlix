<?php

declare(strict_types=1);

namespace Zentlix\Core\UI\Http\Web\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Zentlix\Core\UI\Http\Web\Controller\AbstractRenderController;

class DashboardController extends AbstractRenderController
{
    public function __invoke(): Response
    {
        return $this->render('@Core/admin/dashboard.html.twig');
    }
}
