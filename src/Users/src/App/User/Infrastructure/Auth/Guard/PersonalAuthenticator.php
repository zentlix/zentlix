<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\Auth\Guard;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class PersonalAuthenticator extends AbstractAuthenticator
{
    private const LOGIN = 'login';
    private const SUCCESS_REDIRECT = 'personal';

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->router->generate(self::SUCCESS_REDIRECT));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->router->generate(self::LOGIN);
    }
}
