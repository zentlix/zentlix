<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\ReadModel\Projections;

use Assert\AssertionFailedException;
use Broadway\ReadModel\Projector;
use Zentlix\Users\App\User\Domain\Event\UserGroupWasCreated;
use Zentlix\Users\App\User\Infrastructure\ReadModel\Repository\DoctrineUserGroupRepository;
use Zentlix\Users\App\User\Infrastructure\ReadModel\UserGroupView;

final class UserGroupProjectionFactory extends Projector
{
    public function __construct(
        private readonly DoctrineUserGroupRepository $repository
    ) {
    }

    /**
     * @throws AssertionFailedException
     */
    protected function applyUserGroupWasCreated(UserGroupWasCreated $event): void
    {
        $this->repository->add(UserGroupView::fromSerializable($event));
    }
}
