<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Domain\Specification;

use Zentlix\Users\App\Locale\Domain\Exception\CodeAlreadyExistException;

interface UniqueCodeSpecificationInterface
{
    /**
     * @psalm-param non-empty-string $code
     *
     * @throws CodeAlreadyExistException
     */
    public function isUnique(string $code): bool;
}
