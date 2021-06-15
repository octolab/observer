<?php

declare(strict_types=1);

namespace OctoLab\Observer\Stub;

use OctoLab\Observer;
use OctoLab\Observer\Payload;

class Analytics implements Observer\Analytics
{
    public function send(Payload\Event $event, ?Payload\Context $context = null): void
    {
    }
}
