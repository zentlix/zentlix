<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\ReadModel\Projections;

use Broadway\ReadModel\Projector;
use Doctrine\Common\Collections\ArrayCollection;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\Repository\LocaleRepositoryInterface;
use Zentlix\Users\App\User\Domain\Event\UserWasCreated;
use Zentlix\Users\App\User\Infrastructure\ReadModel\Repository\DoctrineUserRepository;
use Zentlix\Users\App\User\Infrastructure\ReadModel\Repository\UserGroupRepositoryInterface;
use Zentlix\Users\App\User\Infrastructure\ReadModel\UserView;

final class UserProjectionFactory extends Projector
{
    public function __construct(
        private readonly DoctrineUserRepository $repository,
        private readonly UserGroupRepositoryInterface $userGroupRepository,
        private readonly LocaleRepositoryInterface $localeRepository
    ) {
    }

    protected function applyUserWasCreated(UserWasCreated $event): void
    {
        $userView = UserView::fromSerializable($event);

        $userView->groups = new ArrayCollection($this->userGroupRepository->findByUuid($event->groups->getValues()));
        if ($event->locale) {
            $userView->locale = $this->localeRepository->findOneByUuid($event->locale);
        }
        $userView->password = $event->password;

        $this->repository->add($userView);
    }
}
