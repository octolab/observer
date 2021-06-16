<?php

declare(strict_types=1);

namespace Prototype\Graylog;

use OctoLab\Observer;
use OctoLab\Observer\Payload;
use OctoLab\Observer\Type;

class Logger implements Observer\Logger
{
    public function __construct(public readonly \Gelf\Logger $transport)
    {
    }

    public function log(Type\Severity $severity, string $message, ?Payload\Context $context = null): void
    {
        $this->transport->log($severity->value, $message, $context?->fields() ?? []);
    }
}
