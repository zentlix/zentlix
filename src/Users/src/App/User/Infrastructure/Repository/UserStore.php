<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\Repository;

use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Symfony\Component\Uid\Uuid;
use Zentlix\Users\App\User\Domain\Repository\UserRepositoryInterface;
use Zentlix\Users\App\User\Domain\User;

final class UserStore extends EventSourcingRepository implements UserRepositoryInterface
{
    public function __construct(
        EventStore $eventStore,
        EventBus $eventBus,
        array $eventStreamDecorators = []
    ) {
        parent::__construct(
            $eventStore,
            $eventBus,
            User::class,
            new PublicConstructorAggregateFactory(),
            $eventStreamDecorators
        );
    }

    public function store(User $user): void
    {
        $this->save($user);
    }

    public function get(Uuid $uuid): User
    {
        /** @var User $user */
        $user = $this->load($uuid->toRfc4122());

        return $user;
    }
}
