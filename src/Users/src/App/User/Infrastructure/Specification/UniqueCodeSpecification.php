<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\Specification;

use Zentlix\Core\App\Shared\Domain\Specification\AbstractSpecification;
use Zentlix\Users\App\User\Domain\Exception\CodeAlreadyExistException;
use Zentlix\Users\App\User\Domain\Repository\CheckUserGroupByCodeInterface;
use Zentlix\Users\App\User\Domain\Specification\UniqueCodeSpecificationInterface;

final class UniqueCodeSpecification extends AbstractSpecification implements UniqueCodeSpecificationInterface
{
    public function __construct(
        private CheckUserGroupByCodeInterface $checkUserGroupByCode
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
        if ($this->checkUserGroupByCode->existsCode($value)) {
            throw new CodeAlreadyExistException($value);
        }

        return true;
    }
}
