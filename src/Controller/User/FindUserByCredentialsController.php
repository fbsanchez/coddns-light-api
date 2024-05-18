<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\Shared\BaseController;
use App\Modules\Domain\Application\CreateDomain\CreateDomainMessage;
use App\Modules\User\Application\FindUserByCredentials\FindUserByCredentialsQuery;

class FindUserByCredentialsController extends BaseController
{
    public function command(): string
    {
        return FindUserByCredentialsQuery::class;
    }
}
