<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\Specification;

use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\Core\App\Shared\Domain\Specification\AbstractSpecification;
use Zentlix\Users\App\User\Domain\Exception\EmailAlreadyExistException;
use Zentlix\Users\App\User\Domain\Repository\CheckUserByEmailInterface;
use Zentlix\Users\App\User\Domain\Specification\UniqueEmailSpecificationInterface;
use Zentlix\Users\App\User\Domain\ValueObject\Email;

final class UniqueEmailSpecification extends AbstractSpecification implements UniqueEmailSpecificationInterface
{
    public function __construct(
        private readonly CheckUserByEmailInterface $checkUserByEmail,
        private readonly TranslatorInterface $translator
    ) {
    }

    /**
     * @throws EmailAlreadyExistException
     */
    public function isUnique(Email $email): bool
    {
        return $this->isSatisfiedBy($email);
    }

    /**
     * @param Email $value
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function isSatisfiedBy($value): bool
    {
        if ($this->checkUserByEmail->existsEmail($value)) {
            throw new EmailAlreadyExistException(
                $this->translator->trans('users.email.already_exists', ['%email%' => $value->getValue()])
            );
        }

        return true;
    }
}
