<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\Repository;

use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Symfony\Component\Uid\Uuid;
use Zentlix\Users\App\User\Domain\Repository\UserGroupRepositoryInterface;
use Zentlix\Users\App\User\Domain\UserGroup;

final class UserGroupStore extends EventSourcingRepository implements UserGroupRepositoryInterface
{
    public function __construct(
        EventStore $eventStore,
        EventBus $eventBus,
        array $eventStreamDecorators = []
    ) {
        parent::__construct(
            $eventStore,
            $eventBus,
            UserGroup::class,
            new PublicConstructorAggregateFactory(),
            $eventStreamDecorators
        );
    }

    public function store(UserGroup $userGroup): void
    {
        $this->save($userGroup);
    }

    public function get(Uuid $uuid): UserGroup
    {
        /** @var UserGroup $userGroup */
        $userGroup = $this->load($uuid->toRfc4122());

        return $userGroup;
    }
}
