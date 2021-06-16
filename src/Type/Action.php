<?php

declare(strict_types=1);

namespace OctoLab\Observer\Type;

class Action
{
    public function __construct(
        public readonly Flow $flow,
        public readonly Severity $severity = Severity::Error,
        public readonly string $message = '',
        public readonly string $metric = '',
    )
    {
    }

    public function logIsNeeded(): bool
    {
        return $this->message !== '';
    }

    public function countIsNeeded(): bool
    {
        return $this->metric !== '';
    }
}
