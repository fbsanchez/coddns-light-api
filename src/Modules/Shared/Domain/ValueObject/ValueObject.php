<?php
declare(strict_types=1);

namespace App\Modules\Shared\Domain\ValueObject;

abstract class ValueObject
{
    public function __construct()
    {
        $this->assert();
    }

    public static function create(mixed $value): static
    {
        return new static($value);
    }

    abstract public function value(): mixed;

    protected function assert(): void
    {

    }
}