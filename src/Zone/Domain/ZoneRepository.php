<?php
declare(strict_types=1);

namespace App\Zone\Domain;

use App\Zone\Domain\Model\Zone;

interface ZoneRepository
{
    public function find(): Zone;

    public function findByName(string $name): ?Zone;
}