<?php

declare(strict_types=1);

namespace Zentlix\Users\App\Locale\Domain\Event;

use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Uid\Uuid;
use Zentlix\Core\App\Shared\Domain\Event\AbstractSerializableEvent;

final class LocaleWasCreated extends AbstractSerializableEvent
{
    public function __construct(
        public Uuid $uuid,

        /** @psalm-var non-empty-string */
        public string $title,

        /** @psalm-var non-empty-string */
        public string $code,

        /** @psalm-var non-empty-string */
        #[SerializedName('country_code')]
        public string $countryCode,

        /** @psalm-var positive-int */
        public int $sort
    ) {
    }
}
