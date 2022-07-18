<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Application\Query;

use Zentlix\Core\App\Shared\Application\Query\QueryInterface;
use Zentlix\Users\App\User\Domain\ValueObject\Email;

final class GetAuthUserByEmailQuery implements QueryInterface
{
    public readonly Email $email;

    public function __construct(string $email)
    {
        $this->email = new Email($email);
    }
}
