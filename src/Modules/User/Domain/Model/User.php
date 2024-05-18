<?php
declare(strict_types=1);

namespace App\Modules\User\Domain\Model;

final class User
{
    public function __construct(
        private readonly int    $id,
        private readonly string $email,
        private readonly string $hashedPassword,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? null,
            $data['mail'] ?? null,
            $data['pass'] ?? null,
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

    public function hashedPassword(): string
    {
        return $this->hashedPassword;
    }

}