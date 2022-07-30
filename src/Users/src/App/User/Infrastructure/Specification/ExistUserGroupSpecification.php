<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\Specification;

use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;
use Zentlix\Core\App\Shared\Domain\Specification\AbstractSpecification;
use Zentlix\Users\App\User\Domain\Exception\UserGroupIsNotExistException;
use Zentlix\Users\App\User\Domain\Repository\CheckUserGroupInterface;
use Zentlix\Users\App\User\Domain\Specification\ExistUserGroupSpecificationInterface;

final class ExistUserGroupSpecification extends AbstractSpecification implements ExistUserGroupSpecificationInterface
{
    public function __construct(
        private readonly CheckUserGroupInterface $checkUserGroup,
        private readonly TranslatorInterface $translator
    ) {
    }

    /**
     * @param Uuid|Uuid[] $uuid
     *
     * @throws UserGroupIsNotExistException
     */
    public function isExist(array|Uuid $uuid): bool
    {
        return $this->isSatisfiedBy($uuid);
    }

    /**
     * @param Uuid|Uuid[] $value
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function isSatisfiedBy($value): bool
    {
        if ($value instanceof Uuid) {
            $value = [$value];
        }

        $groups = array_map(static fn (Uuid $uuid) => $uuid->toRfc4122(), $this->checkUserGroup->exists($value));

        foreach ($value as $uuid) {
            if (!\in_array($uuid->toRfc4122(), $groups, true)) {
                $this->translator->trans('users.group.is_not_exists', ['%uuid%' => $uuid->toRfc4122()]);
            }
        }

        return true;
    }
}
