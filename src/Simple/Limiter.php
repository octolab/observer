<?php

declare(strict_types=1);

namespace OctoLab\Observer\Simple;

class Limiter
{
    private int $attempt;
    private bool $broken = false;

    public function __construct(private readonly int $limit)
    {
        assert($this->limit > 0);
        $this->attempt = $this->limit;
    }

    public function attempt(): int
    {
        assert($this->limit >= $this->attempt && $this->attempt >= 0);
        return $this->limit - $this->attempt;
    }

    public function break(bool $stop): void
    {
        $this->broken = $stop;
    }

    public function pass(): bool
    {
        if ($this->broken) {
            return false;
        }
        if ($this->attempt === 0) {
            return false;
        }
        assert($this->attempt > 0);
        return $this->attempt-- > 0;
    }

    public function continue(): bool
    {
        return !$this->broken && $this->attempt > 0;
    }
}
