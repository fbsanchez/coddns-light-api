<?php
declare(strict_types=1);

namespace App\Modules\Shared\Domain\ValueObject;

class StringValueObject extends ValueObject
{
    public function __construct(private readonly string $value)
    {
        parent::__construct();
    }

    public function value(): string
    {
        return $this->value;
    }
}