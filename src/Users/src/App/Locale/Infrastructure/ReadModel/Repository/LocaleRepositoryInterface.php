<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Infrastructure\ReadModel\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\Uid\Uuid;
use Zentlix\Users\App\Locale\Infrastructure\ReadModel\LocaleView;

interface LocaleRepositoryInterface
{
    /**
     * @throws NonUniqueResultException
     */
    public function existsCode(string $code): ?Uuid;

    public function add(LocaleView $localeRead): void;

    public function page(int $page, int $limit): PaginationInterface;
}
