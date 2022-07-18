<?php

declare(strict_types=1);

namespace Zentlix\Core\UI\Http\Web\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Throwable;
use Twig\Environment;
use Twig\Error;
use Zentlix\Core\App\Shared\Application\Command\CommandBusInterface;
use Zentlix\Core\App\Shared\Application\Command\CommandInterface;
use Zentlix\Core\App\Shared\Application\Query\QueryBusInterface;
use Zentlix\Core\App\Shared\Application\Query\QueryInterface;

abstract class AbstractRenderController
{
    public function __construct(
        private readonly Environment $twig,
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus,
        private readonly RouterInterface $router
    ) {
    }

    /**
     * @throws Error\LoaderError
     * @throws Error\RuntimeError
     * @throws Error\SyntaxError
     */
    protected function render(string $view, array $parameters = [], int $code = Response::HTTP_OK): Response
    {
        $content = $this->twig->render($view, $parameters);

        return new Response($content, $code);
    }

    protected function redirect(string $url, int $status = Response::HTTP_MOVED_PERMANENTLY): RedirectResponse
    {
        return new RedirectResponse($url, $status);
    }

    protected function redirectToRoute(
        string $route,
        array $parameters = [],
        int $status = 302
    ): RedirectResponse {
        return $this->redirect($this->router->generate($route, $parameters), $status);
    }

    /**
     * @throws Throwable
     */
    protected function handle(CommandInterface $command): void
    {
        $this->commandBus->handle($command);
    }

    /**\
     * @throws Throwable
     */
    protected function ask(QueryInterface $query): mixed
    {
        return $this->queryBus->ask($query);
    }
}
