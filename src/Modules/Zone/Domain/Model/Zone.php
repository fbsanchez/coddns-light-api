<?php
declare(strict_types=1);

namespace App\Modules\Zone\Domain\Model;

use App\Modules\Zone\Domain\Message\ZoneResponse;

final class Zone
{
    public function __construct(
        private readonly int    $id,
        private readonly string $domain,
        private readonly bool   $isPublic,
    )
    {
    }

    public function domain(): string
    {
        return $this->domain;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (int)($data['id'] ?? null),
            $data['domain'] ?? null,
            (bool)($data['is_public'] ?? false),
        );
    }

    public static function fromResponse(ZoneResponse $response): self
    {
        return new self(
            $response->id,
            $response->domain,
            $response->isPublic,
        );
    }

    public function id(): int
    {
        return $this->id;
    }

    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    public function toResponse(): ZoneResponse
    {
        return new ZoneResponse(
            $this->id,
            $this->domain,
            $this->isPublic,
        );
    }
}