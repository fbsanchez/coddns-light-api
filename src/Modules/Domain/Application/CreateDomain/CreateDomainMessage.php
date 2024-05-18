<?php
declare(strict_types=1);

namespace App\Modules\Domain\Application\CreateDomain;

use App\Shared\Domain\Message;

final class CreateDomainMessage implements Message
{
    public function __construct(
        public string $domainName,
        public string $ip,
    )
    {
    }

    public static function fromPrimitives(array $data): self
    {
        return new self(
            $data['domainName'],
            $data['ip'],
        );
    }
}