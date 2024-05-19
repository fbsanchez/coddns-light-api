<?php
declare(strict_types=1);

namespace App\Modules\User\Domain\Model;

use App\Modules\User\Domain\Message\UserResponse;

final class User
{
    public function __construct(
        private readonly int    $id,
        private readonly string $email,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            null === $data['id'] ? null : (int)$data['id'],
            $data['mail'] ?? null,
        );
    }

    public function toResponse(): UserResponse
    {
        return new UserResponse(
            $this->id,
            $this->email,
        );
    }

    public function id(): int
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email;
    }

}