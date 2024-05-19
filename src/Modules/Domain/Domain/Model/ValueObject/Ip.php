<?php
declare(strict_types=1);

namespace App\Modules\Domain\Domain\Model\ValueObject;

use App\Shared\Domain\ValueObject\StringValueObject;

final class Ip extends StringValueObject
{
    public static function createOrNull(?string $value): ?self
    {
        if (null === $value) {
            return null;
        }
        return new self($value);
    }

    public static function fromLong(int $value): self
    {
        return new self(long2ip($value));
    }

    public function toLong(): int
    {
        return ip2long($this->value());
    }
}