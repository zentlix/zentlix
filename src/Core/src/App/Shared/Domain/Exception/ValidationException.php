<?php

declare(strict_types=1);

namespace Zentlix\Core\App\Shared\Domain\Exception;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends \InvalidArgumentException
{
    private array $errors;

    public function __construct(ConstraintViolationListInterface $errors)
    {
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $this->errors[$error->getPropertyPath()] = $error->getMessage();
        }

        parent::__construct('The given data was invalid.');
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
