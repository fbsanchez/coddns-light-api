<?php
declare(strict_types=1);

namespace App\Modules\Domain\Domain\Model\ValueObject;

use App\Modules\Domain\Domain\Exception\InvalidDomainNameException;
use App\Shared\Domain\ValueObject\StringValueObject;
use Safe\Exceptions\PcreException;

final class DomainNameValueObject extends StringValueObject
{
    public const HOST_NAME_FORMAT = '/[^a-zA-Z0-9]/';

    /**
     * @throws PcreException
     */
    protected function assert(): void
    {
        if (0 === \Safe\preg_match(self::HOST_NAME_FORMAT, $this->value())) {
            throw new InvalidDomainNameException($this->value());
        }
    }


}