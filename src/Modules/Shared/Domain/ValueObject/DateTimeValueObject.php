<?php
declare(strict_types=1);

namespace App\Modules\Shared\Domain\ValueObject;

use Safe\DateTime;

final class DateTimeValueObject
{
    public const FORMAT = 'Y-m-d H:i:s';

    public function __construct(private ?DateTime $value = null)
    {
        if (null === $this->value) {
            $this->value = new DateTime();
        }
    }

    public static function create(?string $value): self
    {
        return new self(DateTime::createFromFormat(
            self::FORMAT,
            $value,
        ));
    }

    public function toString(): string
    {
        return $this->value->format(self::FORMAT);
    }
}