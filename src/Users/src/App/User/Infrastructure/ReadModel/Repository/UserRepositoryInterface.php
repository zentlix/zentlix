<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Infrastructure\ReadModel\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Zentlix\Core\App\Shared\Infrastructure\Persistence\ReadModel\Exception\NotFoundException;
use Zentlix\Users\App\User\Domain\ValueObject\Email;
use Zentlix\Users\App\User\Infrastructure\ReadModel\UserView;

interface UserRepositoryInterface
{
    public function add(UserView $userRead): void;

    /**
     * @throws NotFoundException
     * @throws NonUniqueResultException
     */
    public function getByEmail(Email $email): UserView;
}
