<?php

declare(strict_types=1);

namespace App\Controller\Domain;

use App\Controller\Shared\BaseController;
use App\Modules\Domain\Application\CreateDomain\CreateDomainMessage;

class CreateDomainController extends BaseController
{
    public function command(): string
    {
        return CreateDomainMessage::class;
    }
}
