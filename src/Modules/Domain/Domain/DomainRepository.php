<?php
declare(strict_types=1);

namespace App\Modules\Domain\Domain;

use App\Modules\Domain\Domain\Model\Domain;

interface DomainRepository
{
    public function add(Domain $domain): void;

    public function find(): Domain;

    public function findByNameAndUserId(string $fullDomainName, int $userId): ?Domain;

    public function remove(Domain $domain): void;
}