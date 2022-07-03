<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Infrastructure\Repository;

use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Symfony\Component\Uid\Uuid;
use Zentlix\Users\App\Locale\Domain\Locale;
use Zentlix\Users\App\Locale\Domain\Repository\LocaleRepositoryInterface;

final class LocaleStore extends EventSourcingRepository implements LocaleRepositoryInterface
{
    public function __construct(
        EventStore $eventStore,
        EventBus $eventBus,
        array $eventStreamDecorators = []
    ) {
        parent::__construct(
            $eventStore,
            $eventBus,
            Locale::class,
            new PublicConstructorAggregateFactory(),
            $eventStreamDecorators
        );
    }

    public function store(Locale $locale): void
    {
        $this->save($locale);
    }

    public function get(Uuid $uuid): Locale
    {
        /** @var Locale $locale */
        $locale = $this->load($uuid->toRfc4122());

        return $locale;
    }
}
