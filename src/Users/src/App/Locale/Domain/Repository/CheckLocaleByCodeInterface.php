<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Domain\Repository;

use Symfony\Component\Uid\Uuid;

interface CheckLocaleByCodeInterface
{
    /**
     * @psalm-param non-empty-string $code
     */
    public function existsCode(string $code): ?Uuid;
}
