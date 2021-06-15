<?php

declare(strict_types=1);

namespace OctoLab\Observer\Stub;

use OctoLab\Observer;
use OctoLab\Observer\Payload;

class Telemetry implements Observer\Telemetry
{
    public function count(string $metric, int $increment = 1, ?Payload\Context $context = null): void
    {
    }
}
