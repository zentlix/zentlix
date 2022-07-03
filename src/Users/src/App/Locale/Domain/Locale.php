<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Domain;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Symfony\Component\Uid\Uuid;
use Zentlix\Users\App\Locale\Application\Command\CreateCommand;
use Zentlix\Users\App\Locale\Domain\Event\LocaleWasCreated;
use Zentlix\Users\App\Locale\Domain\Service\LocaleValidatorInterface;

class Locale extends EventSourcedAggregateRoot
{
    private Uuid $uuid;

    /** @psalm-var non-empty-string */
    private string $title;

    /** @psalm-var non-empty-string */
    private string $code;

    /** @psalm-var non-empty-string */
    private string $countryCode;

    /** @psalm-var positive-int */
    private int $sort;

    public function __construct(CreateCommand $command, LocaleValidatorInterface $validator)
    {
        $validator->preCreate($command);

        $this->apply(new LocaleWasCreated($command));
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Returns an ISO 639-1 code, such as en.
     *
     * @psalm-return non-empty-string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Returns an ISO 3166-1 alpha-2 country code, such as FR.
     *
     * @psalm-return non-empty-string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * Returns language and country code, such as fr_FR.
     *
     * @psalm-return non-empty-string
     */
    public function getFullCode(): string
    {
        return $this->getCode().'_'.$this->getCountryCode();
    }

    /**
     * @psalm-return positive-int
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    public function getAggregateRootId(): string
    {
        return $this->uuid->toRfc4122();
    }

    protected function applyLocaleWasCreated(LocaleWasCreated $event): void
    {
        $this->uuid = $event->uuid;
        $this->title = $event->title;
        $this->code = $event->code;
        $this->countryCode = $event->countryCode;
        $this->sort = $event->sort;
    }
}
