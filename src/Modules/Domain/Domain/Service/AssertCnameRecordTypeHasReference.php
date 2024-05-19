<?php
declare(strict_types=1);

namespace App\Modules\Domain\Domain\Service;

use App\Modules\Domain\Domain\Exception\InvalidCnameAsForCnameRecordTypeException;
use App\Modules\Domain\Domain\Model\ValueObject\RecordTypeId;

final class AssertCnameRecordTypeHasReference
{
    public function __invoke(int $recordType, string $cname): void
    {
        if (
            RecordTypeId::CNAME === $recordType
            && null === $cname
        ) {
            throw new InvalidCnameAsForCnameRecordTypeException();
        }
    }

}