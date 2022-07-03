<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Domain\Exception;

class CodeAlreadyExistException extends LocaleAlreadyExistException
{
    public function __construct(string $code)
    {
        parent::__construct(sprintf('Locale with symbol code %s already exists.', $code));
    }
}
