<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain\Exception;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

final class UserWithoutGroupException extends UserValidationException
{
    public function __construct()
    {
        parent::__construct(new ConstraintViolationList([
            new ConstraintViolation(
                message: 'The user must have at least one group!',
                messageTemplate: '',
                parameters: [],
                root: '',
                propertyPath: null,
                invalidValue: null
            ),
        ]));
    }
}
