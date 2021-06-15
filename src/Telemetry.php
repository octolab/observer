<?php

declare(strict_types=1);

namespace OctoLab\Observer;

interface Telemetry
{
    public function count(string $metric, int $increment = 1, ?Payload\Context $context = null): void;
}
