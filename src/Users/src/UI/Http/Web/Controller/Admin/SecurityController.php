<?php

declare(strict_types=1);

namespace Zentlix\Users\UI\Http\Web\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Zentlix\Core\UI\Http\Web\Controller\AbstractRenderController;

class SecurityController extends AbstractRenderController
{
    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function login(AuthenticationUtils $authUtils, AuthorizationCheckerInterface $checker): Response
    {
        if ($checker->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('admin.dashboard');
        }

        return $this->render('@Users/admin/security/login.html.twig', [
            'last_username' => $authUtils->getLastUsername(),
            'error' => $authUtils->getLastAuthenticationError(),
        ]);
    }

    public function logout(): void
    {
        throw new AuthenticationException('I shouldn\'t be here.');
    }
}
