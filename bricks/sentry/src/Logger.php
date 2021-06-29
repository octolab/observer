<?php

declare(strict_types=1);

namespace OctoLab\Observer\Bricks\Sentry;

use OctoLab\Observer;
use OctoLab\Observer\Payload\Context;
use OctoLab\Observer\Type\Severity;
use Sentry\State\HubInterface as Sentry;

class Logger implements Observer\Logger
{
    public function __construct(
        public readonly Sentry $transport,
        public readonly Severity $threshold = Severity::Error,
    )
    {
    }

    public function log(Severity $severity, string $message, ?Context $context = null): void
    {
        if ($severity->isHigher($this->threshold) && null !== ($error = $context?->error())) {
            $this->transport->captureException($error);
        }
    }
}
