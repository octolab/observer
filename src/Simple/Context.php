<?php

declare(strict_types=1);

namespace OctoLab\Observer\Simple;

use OctoLab\Observer\Payload;

class Context implements Payload\Context
{
    public function __construct(
        private array $fields = [],
        private array $labels = [],
    )
    {
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
            $context->fields() + $this->fields(),
            $context->labels() + $this->labels(),
        );
    }

    public function with(\Throwable $exception): Payload\Context
    {
        return $this->merge(new self([self::EXCEPTION => $exception]));
    }
}
