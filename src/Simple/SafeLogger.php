<?php

declare(strict_types=1);

namespace OctoLab\Observer\Simple;

use OctoLab\Observer\Logger;
use OctoLab\Observer\Payload;
use OctoLab\Observer\Type;

class SafeLogger implements Logger
{
    public function __construct(private Logger $logger)
    {
    }

    public function log(Type\Severity $severity, string $message, ?Payload\Context $context = null): void
    {
        try {
            $this->logger->log($severity, $message, $context);
        } catch (\Exception) {
            // ignore
        }
    }
}
