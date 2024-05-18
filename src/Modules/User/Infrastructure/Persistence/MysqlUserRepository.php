<?php
declare(strict_types=1);

namespace App\Modules\User\Infrastructure\Persistence;

use App\Modules\User\Domain\Model\User;
use App\Modules\User\Domain\UserRepository;
use App\Shared\Infrastructure\Persistence\MysqlClient;

final class MysqlUserRepository implements UserRepository
{
    private const TABLE = 'users';

    public function __construct(
        private readonly MysqlClient $client,
    )
    {
    }

    public function findUserByEmailAndPassword(string $email, string $password): ?User
    {
        $sql = sprintf(
            'SELECT * FROM %s WHERE email="%s" AND PASSWORD="%s"',
            self::TABLE,
            $this->client->escape($email),
            $this->client->escape($password),
        );

        // TODO: esto peta, no está funcionando el generador como me esperaba
        while ($result = $this->client->get($sql)) {
            return User::fromArray($result);
        }

        return null;
    }
}