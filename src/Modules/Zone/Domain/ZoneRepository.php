<?php
declare(strict_types=1);

namespace App\Modules\Zone\Domain;

use App\Modules\Zone\Domain\Model\Zone;

interface ZoneRepository
{
    public function findByName(string $name): ?Zone;
}