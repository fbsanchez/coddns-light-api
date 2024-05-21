<?php
declare(strict_types=1);

namespace App\Modules\User\Domain\Model\ValueObject;

use App\Modules\Shared\Domain\ValueObject\StringValueObject;
use App\Modules\User\Domain\Exception\InvalidUserEmailException;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

final class UserEmailValueObject extends StringValueObject
{
    protected function assert(): void
    {
        $validator = new EmailValidator();
        if (false === $validator->isValid($this->value(), new RFCValidation())) {
            throw new InvalidUserEmailException($this->value());
        }
    }


}