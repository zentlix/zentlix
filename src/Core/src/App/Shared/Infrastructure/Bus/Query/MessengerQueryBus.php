<?php

declare(strict_types=1);

namespace Zentlix\Core\App\Shared\Infrastructure\Bus\Query;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;
use Zentlix\Core\App\Shared\Application\Query\Collection;
use Zentlix\Core\App\Shared\Application\Query\Item;
use Zentlix\Core\App\Shared\Application\Query\QueryBusInterface;
use Zentlix\Core\App\Shared\Application\Query\QueryInterface;
use Zentlix\Core\App\Shared\Infrastructure\Bus\MessageBusExceptionTrait;

final class MessengerQueryBus implements QueryBusInterface
{
    use MessageBusExceptionTrait;

    public function __construct(
        private readonly MessageBusInterface $messageBus
    ) {
    }

    /**
     * @return Item|Collection|mixed
     *
     * @throws Throwable
     */
    public function ask(QueryInterface $query): mixed
    {
        try {
            $envelope = $this->messageBus->dispatch($query);

            /** @var HandledStamp $stamp */
            $stamp = $envelope->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (HandlerFailedException $e) {
            $this->throwException($e);
        }
    }
}
