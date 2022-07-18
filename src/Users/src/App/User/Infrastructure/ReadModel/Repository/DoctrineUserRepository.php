<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\ReadModel\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Zentlix\Core\App\Shared\Infrastructure\Persistence\ReadModel\Exception\NotFoundException;
use Zentlix\Core\App\Shared\Infrastructure\Persistence\ReadModel\Repository\DoctrineRepository;
use Zentlix\Users\App\User\Domain\ValueObject\Email;
use Zentlix\Users\App\User\Infrastructure\ReadModel\UserView;

final class DoctrineUserRepository extends DoctrineRepository implements UserRepositoryInterface
{
    protected function setEntityManager(): void
    {
        /** @var EntityRepository $objectRepository */
        $objectRepository = $this->entityManager->getRepository(UserView::class);
        $this->repository = $objectRepository;
    }

    public function add(UserView $userRead): void
    {
        $this->register($userRead);
    }

    /**
     * @throws NotFoundException
     * @throws NonUniqueResultException
     */
    public function getByEmail(Email $email): UserView
    {
        $qb = $this->repository
            ->createQueryBuilder('user')
            ->where('email = :email')
            ->setParameter('email', $email->getValue());

        return $this->oneOrException($qb);
    }
}
