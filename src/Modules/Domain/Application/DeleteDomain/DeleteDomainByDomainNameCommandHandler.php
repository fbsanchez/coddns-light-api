<?php
declare(strict_types=1);

namespace App\Modules\Domain\Application\DeleteDomain;

use App\Modules\Domain\Domain\DomainRepository;
use App\Modules\Domain\Domain\Event\DomainDeleted;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final class DeleteDomainByDomainNameCommandHandler
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly DomainRepository    $repository,
    )
    {
    }

    public function __invoke(DeleteDomainByDomainNameCommand $command): void
    {
        $domain = $this->repository->findByNameAndUserId($command->domainName, $command->ownerId);
        if (null === $domain) {
            return;
        }

        $this->repository->remove($domain);

        $this->messageBus->dispatch(DomainDeleted::fromDomain($domain));
    }

}