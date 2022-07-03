<?php

declare(strict_types=1);

namespace Zentlix\Core\App\Shared\Domain\Specification;

abstract class AbstractSpecification
{
    abstract public function isSatisfiedBy(mixed $value): bool;
}
