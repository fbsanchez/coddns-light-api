<?php
declare(strict_types=1);

namespace App\Modules\User\Infrastructure\Persistence;

use App\Modules\Shared\Infrastructure\Persistence\MysqlClient;
use App\Modules\User\Domain\Model\User;
use App\Modules\User\Domain\UserRepository;

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
            'SELECT * FROM %s WHERE mail="%s" AND pass="%s"',
            self::TABLE,
            $this->client->escape($email),
            $this->client->escape($password),
        );

        // TODO: esto peta, no está funcionando el generador como me esperaba
        $result = $this->client->get($sql);
        if (is_array($result)) {
            return User::fromArray($result);
        }

        return null;
    }
}