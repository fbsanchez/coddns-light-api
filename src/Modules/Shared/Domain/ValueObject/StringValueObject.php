<?php
declare(strict_types=1);

namespace App\Modules\Shared\Domain\ValueObject;

use RuntimeException;

class StringValueObject extends ValueObject
{
    public function value(): string
    {
        return $this->value;
    }

    protected function assert(): void
    {
        if (false === is_string($this->value)) {
            throw new RuntimeException('Invalid string value ', $this->value);
        }
    }
}