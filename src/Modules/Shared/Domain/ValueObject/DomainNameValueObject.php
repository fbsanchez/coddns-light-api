<?php
declare(strict_types=1);

namespace App\Modules\Shared\Domain\ValueObject;

use App\Modules\Domain\Domain\Exception\InvalidDomainNameException;
use Safe\Exceptions\PcreException;

final class DomainNameValueObject extends StringValueObject
{
    public const HOST_NAME_FORMAT = '/^[a-zA-Z0-9\-_]+\.\w+\.\w+$/';

    public function getBaseDomainName(): string
    {
        preg_match('/.*?\.(\w+\.\w+)/', $this->value(), $matches);

        return $matches[1];

    }

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