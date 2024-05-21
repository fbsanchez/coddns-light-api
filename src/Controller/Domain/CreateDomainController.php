<?php

declare(strict_types=1);

namespace App\Controller\Domain;

use App\Controller\Shared\BaseController;
use App\Modules\Domain\Application\CreateDomain\CreateDomainCommand;
use App\Modules\Domain\Domain\Exception\InvalidCnameAsForCnameRecordTypeException;
use App\Modules\Domain\Domain\Exception\InvalidDomainNameException;
use App\Modules\Domain\Domain\Exception\InvalidRecordTypeException;
use Symfony\Component\HttpFoundation\Response;

class CreateDomainController extends BaseController
{
    public function command(): string
    {
        return CreateDomainCommand::class;
    }

    public function customParameters(array $parameters): array
    {
        return [
            ...$parameters,
            CreateDomainCommand::OWNER_ID => $this->getAuthUser()->id(),
        ];
    }

    public static function exceptions(): array
    {
        return [
            InvalidDomainNameException::class                => Response::HTTP_BAD_REQUEST,
            InvalidRecordTypeException::class                => Response::HTTP_BAD_REQUEST,
            InvalidCnameAsForCnameRecordTypeException::class => Response::HTTP_BAD_REQUEST,
        ];
    }
}
