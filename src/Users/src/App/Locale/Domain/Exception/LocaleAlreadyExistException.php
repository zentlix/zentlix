<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Domain\Exception;

class LocaleAlreadyExistException extends \InvalidArgumentException
{
    public function __construct(string $message = 'Locale already exists.')
    {
        parent::__construct($message);
    }
}
