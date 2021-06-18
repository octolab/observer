<?php

declare(strict_types=1);

namespace OctoLab\Observer\Type;

class Action
{
    public function __construct(
        public readonly \Throwable $error,
        public readonly Flow $flow = Flow::repeat,
        public readonly Severity $severity = Severity::Error,
        public readonly ?string $message = null,
        public readonly ?string $metric = null,
    )
    {
    }

    public function countIsNeeded(): bool
    {
        return !empty($this->metric);
    }

    public function debugIsNeeded(): bool
    {
        return $this->severity->value < Severity::Error->value;
    }

    public function logIsNeeded(): bool
    {
        return !empty($this->message);
    }
}
