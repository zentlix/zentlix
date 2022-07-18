<?php

declare(strict_types=1);

namespace Zentlix\Users\App\User\Domain;

class ResetToken
{
    private ?string $token;
    private ?\DateTimeInterface $expires;

    public function __construct(string $token = null, \DateTimeInterface $expires = null)
    {
        $this->token = $token;
        $this->expires = $expires;
    }

    public function isExpiredTo(\DateTimeInterface $expiredTo): bool
    {
        return $this->expires <= $expiredTo;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function getExpires(): ?\DateTimeInterface
    {
        return $this->expires;
    }

    /**
     * @internal for postLoad callback
     */
    public function isEmpty(): bool
    {
        return empty($this->token);
    }
}
