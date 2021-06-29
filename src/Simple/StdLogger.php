<?php

declare(strict_types=1);

namespace OctoLab\Observer\Simple;

use OctoLab\Observer\Logger;
use OctoLab\Observer\Payload;
use OctoLab\Observer\Type;

class StdLogger implements Logger
{
    public function log(Type\Severity $severity, string $message, ?Payload\Context $context = null): void
    {
    }
}
