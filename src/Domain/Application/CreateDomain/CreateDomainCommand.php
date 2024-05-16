<?php
declare(strict_types=1);

namespace App\Domain\Application\CreateDomain;

use App\Shared\Domain\Command;

final class CreateDomainCommand implements Command
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