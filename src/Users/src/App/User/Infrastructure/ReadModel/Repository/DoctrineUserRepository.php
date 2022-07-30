<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\ReadModel\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Uid\Uuid;
use Zentlix\Core\App\Shared\Infrastructure\Persistence\ReadModel\Exception\NotFoundException;
use Zentlix\Core\App\Shared\Infrastructure\Persistence\ReadModel\Repository\DoctrineRepository;
use Zentlix\Users\App\User\Domain\Repository\CheckUserByEmailInterface;
use Zentlix\Users\App\User\Domain\ValueObject\Email;
use Zentlix\Users\App\User\Infrastructure\ReadModel\UserView;

final class DoctrineUserRepository extends DoctrineRepository implements UserRepositoryInterface, CheckUserByEmailInterface
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
        $qb = $this->getUserByEmailQueryBuilder($email);

        return $this->oneOrException($qb);
    }

    public function existsEmail(Email $email): ?Uuid
    {
        $user = $this->getUserByEmailQueryBuilder($email)
            ->select('user.uuid')
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY)
        ;

        return $user['uuid'] ?? null;
    }

    private function getUserByEmailQueryBuilder(Email $email): QueryBuilder
    {
        return $this->repository
            ->createQueryBuilder('user')
            ->where('user.email = :email')
            ->setParameter('email', $email->getValue());
    }
}
