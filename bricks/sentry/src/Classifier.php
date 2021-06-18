<?php

declare(strict_types=1);

namespace OctoLab\Observer\Bricks\Sentry;

use JetBrains\PhpStorm\Pure;
use OctoLab\Observer;
use OctoLab\Observer\Type;

class Classifier implements Observer\Classifier
{
    #[Pure] public function classify(\Throwable $error): Type\Action
    {
        return match (true) {
            $error instanceof \OverflowException => new Type\Action(
                $error,
                severity: Type\Severity::Alert,
                message: '{name}: overflow is happened, attempt number {attempt}...',
                metric: 'overflow_count',
            ),
            $error instanceof \RuntimeException => new Type\Action(
                $error,
                severity: Type\Severity::Critical,
                message: '{name}: runtime exception "{exception}", attempt number {attempt}...',
            ),
            $error instanceof \DomainException => new Type\Action(
                $error,
                flow: Type\Flow::ignore,
            ),
            $error instanceof \LogicException => new Type\Action(
                $error,
                message: '{name}: broken logic "{exception}", attempt number {attempt}...',
            ),
            default => new Type\Action($error, Type\Flow::throw),
        };
    }
}
