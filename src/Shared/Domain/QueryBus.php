<?php
declare(strict_types=1);

namespace App\Shared\Domain;

interface QueryBus
{
    public function ask(Query $query): QueryResponse|array|null;
}