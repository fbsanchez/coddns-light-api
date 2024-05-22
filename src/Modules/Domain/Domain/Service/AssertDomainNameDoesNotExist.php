<?php
declare(strict_types=1);

namespace App\Modules\Domain\Domain\Service;

use App\Modules\Domain\Domain\DomainRepository;
use App\Modules\Domain\Domain\Exception\InvalidDomainNameException;
use App\Modules\Shared\Domain\ValueObject\DomainNameValueObject;

final class AssertDomainNameDoesNotExist
{
    public function __construct(
        private DomainRepository $repository,
    )
    {
    }

    public function __invoke(DomainNameValueObject $domainName): void
    {
        $result = $this->repository->findByName($domainName->value());
        if (null !== $result) {
            throw new InvalidDomainNameException('Domain already exists');
        }

    }

}