<?php

declare(strict_types=1);

namespace OctoLab\Observer\Payload;

interface Context
{
    public function attempt(): int;

    /**
     * Provides context for logging.
     *
     * @return array<string, string>
     */
    public function fields(): array;

    /**
     * Provides context for telemetry.
     *
     * @return array<string, string>
     */
    public function labels(): array;

    public function merge(Context $context): Context;
}
