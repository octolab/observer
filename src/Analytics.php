<?php

declare(strict_types=1);

namespace OctoLab\Observer;

interface Analytics
{
    public function send(Payload\Event $event, ?Payload\Context $context = null): void;
}
