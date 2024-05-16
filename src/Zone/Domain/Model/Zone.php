<?php
declare(strict_types=1);

namespace App\Zone\Domain\Model;

final class Zone
{
    public function __construct(
        private readonly int    $id,
        private readonly string $domain,
    )
    {
    }

    public function domain(): string
    {
        return $this->domain;
    }

    public function id(): int
    {
        return $this->id;
    }


}