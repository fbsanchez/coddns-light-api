<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\Shared\BaseController;
use App\Controller\Shared\QueryController;
use App\Modules\Domain\Application\CreateDomain\CreateDomainCommand;
use App\Modules\User\Application\FindUserByCredentials\FindUserByCredentialsQuery;

class LoginController extends QueryController
{
    function query(): string
    {
        return FindUserByCredentialsQuery::class;
    }
}
