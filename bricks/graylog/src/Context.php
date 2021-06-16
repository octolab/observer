<?php

declare(strict_types=1);

namespace Prototype\Graylog;

use OctoLab\Observer\Payload;

class Context implements Payload\Context
{
    public function __construct(
        private array $fields = [],
        private array $labels = [],
        private int $attempt = 0,
    )
    {
    }

    public function attempt(): int
    {
        return ++$this->attempt;
    }

    public function fields(): array
    {
        return $this->fields;
    }

    public function labels(): array
    {
        return $this->labels;
    }

    public function merge(Payload\Context $context): Payload\Context
    {
        return new self(
            $this->fields() + $context->fields(),
            $this->labels() + $context->labels(),
            max($this->attempt(), $context->attempt()),
        );
    }
}
