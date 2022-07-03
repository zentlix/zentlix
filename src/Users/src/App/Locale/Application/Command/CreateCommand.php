<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Application\Command;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints;
use Zentlix\Core\App\Shared\Application\Command\CreateCommandInterface;

class CreateCommand implements CreateCommandInterface
{
    public Uuid $uuid;

    /** @psalm-var non-empty-string */
    #[Constraints\NotBlank]
    public string $title;

    /**
     * @psalm-var non-empty-string
     */
    #[Constraints\NotBlank]
    public string $code;

    /**
     * @psalm-var non-empty-string
     */
    #[Constraints\NotBlank]
    public string $countryCode;

    /** @psalm-var positive-int */
    #[Constraints\Positive]
    public int $sort = 1;

    public function __construct()
    {
        $this->uuid = Uuid::v4();
    }
}
