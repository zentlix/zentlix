<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\ReadModel\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Uid\Uuid;
use Zentlix\Core\App\Shared\Infrastructure\Persistence\ReadModel\Repository\DoctrineRepository;
use Zentlix\Users\App\User\Domain\Repository\CheckUserGroupByCodeInterface;
use Zentlix\Users\App\User\Domain\Repository\CheckUserGroupInterface;
use Zentlix\Users\App\User\Infrastructure\ReadModel\UserGroupView;

final class DoctrineUserGroupRepository extends DoctrineRepository implements UserGroupRepositoryInterface, CheckUserGroupByCodeInterface, CheckUserGroupInterface
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

    public function findAll(array $orderBy = ['sort' => 'asc']): array
    {
        return $this->repository->findBy([], $orderBy);
    }

    /**
     * @param Uuid|Uuid[] $uuid
     *
     * @psalm-return ($uuid is array ? array : ?Uuid)
     */
    public function exists(array|Uuid $uuid): Uuid|array|null
    {
        $query = $this->getUserGroupQueryBuilder($uuid)
            ->select('userGroup.uuid')
            ->getQuery();

        if ($uuid instanceof Uuid) {
            return $query->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY)['uuid'] ?? null;
        }

        return array_column($query->getResult(AbstractQuery::HYDRATE_ARRAY), 'uuid');
    }

    /**
     * @return UserGroupView[]
     */
    public function findByUuid(array $uuid, array $orderBy = ['userGroup.sort' => 'asc']): array
    {
        $sort = array_key_first($orderBy);

        if (empty($sort) || empty($orderBy[$sort])) {
            throw new \InvalidArgumentException('The `$orderBy` parameter must be an array, with the key being
                the sort field and the value being the sort direction.');
        }

        return $this
            ->getUserGroupQueryBuilder($uuid)
            ->orderBy($sort, $orderBy[$sort])
            ->getQuery()
            ->getResult();
    }

    private function getUserGroupByCodeQueryBuilder(string $code): QueryBuilder
    {
        return $this->repository
            ->createQueryBuilder('userGroup')
            ->where('userGroup.code = :code')
            ->setParameter('code', $code);
    }

    /** @param Uuid|Uuid[] $uuid */
    private function getUserGroupQueryBuilder(Uuid|array $uuid): QueryBuilder
    {
        if ($uuid instanceof Uuid) {
            $uuid = [$uuid];
        }

        $qb = $this->repository->createQueryBuilder('userGroup');

        return $qb->where(
            $qb->expr()->in('userGroup.uuid', array_map(static fn (Uuid $uuid) => $uuid->toRfc4122(), $uuid))
        );
    }
}
