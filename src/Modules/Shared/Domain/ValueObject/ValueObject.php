<?php
declare(strict_types=1);

namespace App\Modules\Shared\Domain\ValueObject;

abstract class ValueObject
{
    final public function __construct(protected mixed $value)
    {
    }

    protected function assert(): void
    {

    }

    public static function createOrNull(mixed $value): ?static
    {
        if (null === $value) {
            return null;
        }

        return self::create($value);
    }

    public static function create(mixed $value): static
    {
        return new static($value);
    }

    abstract public function value(): mixed;
}