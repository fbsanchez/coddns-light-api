<?php
declare(strict_types=1);

namespace App\Modules\User\Domain;

use App\Modules\User\Domain\Model\User;

interface UserRepository
{
    public function findUserByEmailAndPassword(string $email, string $password): ?User;
}