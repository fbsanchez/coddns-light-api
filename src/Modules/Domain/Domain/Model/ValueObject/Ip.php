<?php
declare(strict_types=1);

namespace App\Modules\Domain\Domain\Model\ValueObject;

use App\Modules\Shared\Domain\ValueObject\StringValueObject;

final class Ip extends StringValueObject
{
    public static function fromLong(int $value): self
    {
        return new self(long2ip($value));
    }

    public function toLong(): int
    {
        return ip2long($this->value());
    }
}