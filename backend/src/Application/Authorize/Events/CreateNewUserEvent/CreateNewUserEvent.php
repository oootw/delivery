<?php

declare(strict_types=1);

namespace App\Application\Authorize\Events\CreateNewUserEvent;

use App\Shared\Traits\InfoTrait\InfoTrait;
use Symfony\Contracts\EventDispatcher\Event;

class CreateNewUserEvent extends Event
{
    use InfoTrait;
    public function __construct(private CreateNewUserEventPayload $payload) {}

    public function getPayload(): CreateNewUserEventPayload
    {
        return $this->payload;
    }
}
