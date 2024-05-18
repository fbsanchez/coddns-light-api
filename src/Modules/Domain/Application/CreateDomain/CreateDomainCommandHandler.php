<?php
declare(strict_types=1);

namespace App\Modules\Domain\Application\CreateDomain;

use App\Modules\Domain\Domain\DomainRepository;
use App\Modules\Domain\Domain\Model\Domain;
use App\Modules\Domain\Domain\Model\ValueObject\DomainNameValueObject;
use Safe\DateTime;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateDomainCommandHandler
{
    public function __construct(
        private DomainRepository $repository,
    )
    {
    }

    public function __invoke(CreateDomainMessage $command): void
    {
        $this->repository->add(new Domain(
            id: 1,
            userId: 1,
            domainName: DomainNameValueObject::create($command->domainName),
            ip: $command->ip,
            created: new DateTime(),
            lastUpdated: new DateTime(),
            groupId: 1,
            registerTypeId: 1,
            domainId: null,
            zoneId: 1,
            ttl: 12,
            rtag: "",
        ));
    }
}