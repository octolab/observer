<?php

declare(strict_types=1);

namespace OctoLab\Observer\Bricks\Sentry;

use OctoLab\Observer;
use Sentry\State\Hub as Sentry;

class Debugger implements Observer\Debugger
{
    public function __construct(public readonly Sentry $transport)
    {
    }

    public function debug(\Throwable $error): void
    {
        $_ = $this->transport->captureException($error);
    }
}
