<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain\Repository;

use Symfony\Component\Uid\Uuid;

interface CheckUserGroupByCodeInterface
{
    /**
     * @psalm-param non-empty-string $code
     */
    public function existsCode(string $code): ?Uuid;
}
