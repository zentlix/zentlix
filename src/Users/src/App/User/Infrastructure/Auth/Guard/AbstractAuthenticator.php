<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\Auth\Guard;

use Assert\AssertionFailedException;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Throwable;
use Zentlix\Core\App\Shared\Application\Command\CommandBusInterface;
use Zentlix\Core\App\Shared\Application\Query\QueryBusInterface;
use Zentlix\Users\App\User\Application\Command\SignInCommand;
use Zentlix\Users\App\User\Application\Query\GetAuthUserByEmailQuery;
use Zentlix\Users\App\User\Domain\Exception\InvalidCredentialsException;

abstract class AbstractAuthenticator extends AbstractLoginFormAuthenticator
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus,
        protected readonly UrlGeneratorInterface $router
    ) {
    }

    private function getCredentials(Request $request): array
    {
        return [
            'email' => $request->request->get('_email'),
            'password' => $request->request->get('_password'),
        ];
    }

    /**
     * @throws AssertionFailedException
     * @throws Throwable
     */
    public function authenticate(Request $request): Passport
    {
        $credentials = $this->getCredentials($request);

        try {
            $signInCommand = new SignInCommand($credentials['email'], $credentials['password']);

            $this->commandBus->handle($signInCommand);

            return new Passport(
                new UserBadge($credentials['email'], function (string $email) {
                    return $this->queryBus->ask(new GetAuthUserByEmailQuery($email));
                }),
                new PasswordCredentials($credentials['password'])
            );
        } catch (InvalidCredentialsException|InvalidArgumentException) {
            throw new AuthenticationException();
        }
    }
}
