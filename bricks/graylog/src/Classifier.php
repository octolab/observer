<?php

declare(strict_types=1);

namespace Prototype\Graylog;

use JetBrains\PhpStorm\Pure;
use OctoLab\Observer;
use OctoLab\Observer\Type;

class Classifier implements Observer\Classifier
{
    #[Pure] public function classify(\Throwable $exception): Type\Action
    {
        return match ($exception::class) {
            \DomainException::class => new Type\Action(
                $exception,
                Type\Flow::repeat,
                message: '{name} integration example. Attempt number {attempt}...',
            ),
            default => new Type\Action($exception, Type\Flow::throw),
        };
    }
}
