<?php

declare(strict_types=1);

namespace OctoLab\Observer\Bricks\Sentry;

use OctoLab\Observer;
use OctoLab\Observer\Payload\Context;
use OctoLab\Observer\Type\Severity;
use Sentry\State\Hub as Sentry;

class Logger implements Observer\Logger
{
    public function __construct(public readonly Sentry $transport)
    {
    }

    public function log(Severity $severity, string $message, ?Context $context = null): void
    {
        if ($severity->value < Severity::Error->value && null !== ($error = $context?->error())) {
            $this->transport->captureException($error);
        }
    }
}
