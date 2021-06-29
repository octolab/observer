<?php

declare(strict_types=1);

namespace OctoLab\Observer\Simple;

use OctoLab\Observer\Logger;
use OctoLab\Observer\Payload;
use OctoLab\Observer\Type;

class PipeLogger implements Logger
{
    /** @var Logger[] */
    private array $loggers;

    public function __construct(Logger ...$loggers)
    {
        $this->loggers = $loggers;
    }

    public function log(Type\Severity $severity, string $message, ?Payload\Context $context = null): void
    {
        foreach ($this->loggers as $logger) {
            $logger->log($severity, $message, $context);
        }
    }
}
