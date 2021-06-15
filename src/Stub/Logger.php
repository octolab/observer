<?php

declare(strict_types=1);

namespace OctoLab\Observer\Stub;

use OctoLab\Observer;
use OctoLab\Observer\Payload;

class Logger implements Observer\Logger
{
    public function log(int $severity, string $message, ?Payload\Context $context = null): void
    {
    }
}
