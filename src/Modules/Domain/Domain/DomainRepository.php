<?php
declare(strict_types=1);

namespace App\Modules\Domain\Domain;

use App\Modules\Domain\Domain\Model\Domain;

interface DomainRepository
{
    public function add(Domain $domain): void;

    public function findByNameAndUserId(string $fullDomainName, int $userId): ?Domain;

    public function findByName(string $fullDomainName): ?Domain;

    public function remove(Domain $domain): void;

    public function searchByOwner(int $ownerId): array;
}