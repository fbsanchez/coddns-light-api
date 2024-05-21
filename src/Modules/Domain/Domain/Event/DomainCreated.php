<?php
declare(strict_types=1);

namespace App\Modules\Domain\Domain\Event;

use App\Modules\Shared\Domain\Message;

final class DomainCreated implements Message
{
    use DomainTrait;
}