<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\Auth\Guard;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class AdminAuthenticator extends AbstractAuthenticator
{
    private const LOGIN = 'admin.login';
    private const SUCCESS_REDIRECT = 'admin.dashboard';

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->router->generate(self::SUCCESS_REDIRECT));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->router->generate(self::LOGIN);
    }
}
