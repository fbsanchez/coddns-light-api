<?php
declare(strict_types=1);

namespace App\Controller\Domain;

use App\Controller\Shared\BaseController;
use App\Modules\Domain\Application\DeleteDomain\DeleteDomainByDomainNameCommand;

final class DeleteDomainByDomainNameController extends BaseController
{

    function command(): string
    {
        return DeleteDomainByDomainNameCommand::class;
    }

    public function customParameters(array $parameters): array
    {
        return [
            ...$parameters,
            DeleteDomainByDomainNameCommand::OWNER_ID => $this->getAuthUser()->id(),
        ];
    }
}