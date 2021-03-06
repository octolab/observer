<?php

declare(strict_types=1);

namespace OctoLab\Observer;

interface Logger
{
    public function log(Type\Severity $severity, string $message, ?Payload\Context $context = null): void;
}
