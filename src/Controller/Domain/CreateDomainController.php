<?php

declare(strict_types=1);

namespace App\Controller\Domain;

use App\Controller\Shared\BaseController;
use App\Domain\Application\CreateDomain\CreateDomainCommand;
use App\Shared\Domain\Command;

class CreateDomainController extends BaseController
{
    public function command(): string
    {
        return CreateDomainCommand::class;
    }
}
