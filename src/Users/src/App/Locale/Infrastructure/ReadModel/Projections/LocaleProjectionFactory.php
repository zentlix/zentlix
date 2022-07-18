<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Infrastructure\ReadModel\Projections;

use Assert\AssertionFailedException;
use Broadway\ReadModel\Projector;
use Zentlix\Users\App\Locale\Domain\Event\LocaleWasCreated;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\LocaleView;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\Repository\DoctrineLocaleRepository;

final class LocaleProjectionFactory extends Projector
{
    public function __construct(
        private readonly DoctrineLocaleRepository $repository
    ) {
    }

    /**
     * @throws AssertionFailedException
     */
    protected function applyLocaleWasCreated(LocaleWasCreated $event): void
    {
        $this->repository->add(LocaleView::fromSerializable($event));
    }
}
