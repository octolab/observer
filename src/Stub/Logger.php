<?php

declare(strict_types=1);

namespace OctoLab\Observer\Stub;

use OctoLab\Observer;
use OctoLab\Observer\Payload;
use OctoLab\Observer\Type;

class Logger implements Observer\Logger
{
    public function log(Type\Severity $severity, string $message, ?Payload\Context $context = null): void
    {
    }
}
