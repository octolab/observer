<?php

declare(strict_types=1);

namespace OctoLab\Observer\Simple;

use OctoLab\Observer\Payload;
use OctoLab\Observer\Telemetry;

class SafeTelemetry implements Telemetry
{
    public function __construct(private Telemetry $telemetry)
    {
    }

    public function count(string $metric, int $increment = 1, ?Payload\Context $context = null): void
    {
        try {
            $this->telemetry->count($metric, $increment, $context);
        } catch (\Throwable) {
            // ignore
        }
    }
}
