<?php

declare(strict_types=1);

namespace Zentlix\Users\UI\Http\Web\Controller;

use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Zentlix\Core\UI\Http\Web\Controller\AbstractRenderController;

class SecurityController extends AbstractRenderController
{
    public function logout(): void
    {
        throw new AuthenticationException('I shouldn\'t be here.');
    }
}
