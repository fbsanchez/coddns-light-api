<?php
declare(strict_types=1);

namespace App\Modules\Domain\Domain;

use App\Modules\Domain\Domain\Model\Domain;

interface DnsHandler
{
    public function add(Domain $domain): void;

    public function remove(Domain $domain): void;
}