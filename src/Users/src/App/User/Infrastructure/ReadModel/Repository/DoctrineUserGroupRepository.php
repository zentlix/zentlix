<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\ReadModel\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Uid\Uuid;
use Zentlix\Core\App\Shared\Infrastructure\Persistence\ReadModel\Repository\DoctrineRepository;
use Zentlix\Users\App\User\Domain\Repository\CheckUserGroupByCodeInterface;
use Zentlix\Users\App\User\Infrastructure\ReadModel\UserGroupView;

final class DoctrineUserGroupRepository extends DoctrineRepository implements UserGroupRepositoryInterface, CheckUserGroupByCodeInterface
{
    protected function setEntityManager(): void
    {
        /** @var EntityRepository $objectRepository */
        $objectRepository = $this->entityManager->getRepository(UserGroupView::class);
        $this->repository = $objectRepository;
    }

    public function add(UserGroupView $userGroupRead): void
    {
        $this->register($userGroupRead);
    }

    public function existsCode(string $code): ?Uuid
    {
        $userGroup = $this->getUserGroupByCodeQueryBuilder($code)
            ->select('userGroup.uuid')
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY)
        ;

        return $userGroup['uuid'] ?? null;
    }

    private function getUserGroupByCodeQueryBuilder(string $code): QueryBuilder
    {
        return $this->repository
            ->createQueryBuilder('userGroup')
            ->where('userGroup.code = :code')
            ->setParameter('code', $code);
    }
}
