<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Zentlix\Core\App\Shared\Domain\Exception\ValidationException;

final class UserGroupValidationException extends ValidationException
{
    public function __construct(ConstraintViolationListInterface $errors)
    {
        parent::__construct($errors);
    }
}
