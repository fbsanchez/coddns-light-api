<?php
declare(strict_types=1);

namespace App\Modules\Domain\Domain\Model\ValueObject;


use App\Modules\Domain\Domain\Exception\InvalidRecordTypeException;

final class RecordTypeId
{
    public const A = 1;
    public const NS = 2;
    public const CNAME = 3;
    public const MX = 4;

    public function __construct(private int $value)
    {
        $this->assert();
    }

    private function assert(): void
    {
        if (false === in_array(
                $this->value,
                [
                    self::A,
                    self::NS,
                    self::CNAME,
                    self::MX,
                ],
            )) {
            throw new InvalidRecordTypeException('Invalid Record Type ID');
        }
    }

    public static function create(int $value): self
    {
        return new self($value);
    }

    public static function map(string $type): int
    {
        return match ($type) {
            'A' => self::A,
            'NS' => self::NS,
            'CNAME' => self::CNAME,
            'MX' => self::MX,
            default => throw new InvalidRecordTypeException($type),
        };
    }

    public function toString(): string
    {
        return match ($this->value) {
            self::A => 'A',
            self::NS => 'NS',
            self::CNAME => 'CNAME',
            self::MX => 'MX',
            default => 'Unknown',
        };
    }

    public function value(): int
    {
        return $this->value;
    }
}