<?php
declare(strict_types=1);

namespace App\Modules\Domain\Domain\Model\ValueObject;

use function App\Modules\User\Domain\Model\ValueObject\InvalidRecordTypeException;

final class RecordTypeId
{
    public const A = 1;
    public const NS = 2;
    public const CNAME = 3;
    public const MX = 4;

    public static function map(string $type): int
    {
        return match ($type) {
            'A' => self::A,
            'NS' => self::NS,
            'CNAME' => self::CNAME,
            'MX' => self::MX,
            default => throw InvalidRecordTypeException($type),
        };
    }
}