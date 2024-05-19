<?php

declare(strict_types=1);

namespace App\Controller\Domain;

use App\Controller\Shared\BaseController;
use App\Modules\Domain\Application\CreateDomain\CreateDomainCommand;

class CreateDomainController extends BaseController
{
    public function command(): string
    {
        return CreateDomainCommand::class;
    }

    public function customParameters(array $parameters): array
    {
        return [ CreateDomainCommand::OWNER_ID => $this->getAuthUser()->id() ];
    }
}
