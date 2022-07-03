<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Infrastructure\Specification;

use Zentlix\Core\App\Shared\Domain\Specification\AbstractSpecification;
use Zentlix\Users\App\Locale\Domain\Exception\CodeAlreadyExistException;
use Zentlix\Users\App\Locale\Domain\Repository\CheckLocaleByCodeInterface;
use Zentlix\Users\App\Locale\Domain\Specification\UniqueCodeSpecificationInterface;

final class UniqueCodeSpecification extends AbstractSpecification implements UniqueCodeSpecificationInterface
{
    public function __construct(
        private CheckLocaleByCodeInterface $checkLocaleByCode
    ) {
    }

    /**
     * @psalm-param non-empty-string $code
     *
     * @throws CodeAlreadyExistException
     */
    public function isUnique(string $code): bool
    {
        return $this->isSatisfiedBy($code);
    }

    /**
     * @psalm-param non-empty-string $value
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function isSatisfiedBy($value): bool
    {
        if ($this->checkLocaleByCode->existsCode($value)) {
            throw new CodeAlreadyExistException($value);
        }

        return true;
    }
}
