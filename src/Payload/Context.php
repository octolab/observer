<?php

declare(strict_types=1);

namespace OctoLab\Observer\Payload;

interface Context
{
    final public const EXCEPTION = 'exception';

    /**
     * Returns an error associated with the context.
     */
    public function error(): ?\Throwable;

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

    /**
     * Combines current context with the passed into a new one.
     */
    public function merge(Context $context): Context;

    /**
     * Adds the error to fields with the 'exception' key.
     */
    public function with(\Throwable $exception): Context;
}
