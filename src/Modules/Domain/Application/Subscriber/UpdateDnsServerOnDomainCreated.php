<?php
declare(strict_types=1);

namespace App\Modules\Domain\Application\Subscriber;

use App\Modules\Domain\Domain\DnsHandler;
use App\Modules\Domain\Domain\Event\DomainCreated;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class UpdateDnsServerOnDomainCreated
{
    public function __construct(
        private readonly DnsHandler $dnsHandler,
    )
    {
    }

    public function __invoke(DomainCreated $event): void
    {
        $this->dnsHandler->add($event->toDomain());
    }

}