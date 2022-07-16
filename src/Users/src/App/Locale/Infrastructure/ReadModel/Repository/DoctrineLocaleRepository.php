<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Infrastructure\ReadModel\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\Uid\Uuid;
use Zentlix\Core\App\Shared\Infrastructure\Persistence\ReadModel\Repository\DoctrineRepository;
use Zentlix\Users\App\Locale\Domain\Repository\CheckLocaleByCodeInterface;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\LocaleView;

final class DoctrineLocaleRepository extends DoctrineRepository implements LocaleRepositoryInterface, CheckLocaleByCodeInterface
{
    protected function setEntityManager(): void
    {
        /** @var EntityRepository $objectRepository */
        $objectRepository = $this->entityManager->getRepository(LocaleView::class);
        $this->repository = $objectRepository;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function existsCode(string $code): ?Uuid
    {
        $locale = $this->getLocaleByCodeQueryBuilder($code)
            ->select('locale.uuid')
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY)
        ;

        return $locale['uuid'] ?? null;
    }

    public function add(LocaleView $localeRead): void
    {
        $this->register($localeRead);
    }

    public function page(int $page, int $limit): PaginationInterface
    {
        $query = $this->repository
            ->createQueryBuilder('locale');

        return $this->paginator->paginate($query, $page, $limit);
    }

    private function getLocaleByCodeQueryBuilder(string $code): QueryBuilder
    {
        return $this->repository
            ->createQueryBuilder('locale')
            ->where('locale.code = :code')
            ->setParameter('code', $code);
    }
}
