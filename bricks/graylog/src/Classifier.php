<?php

declare(strict_types=1);

namespace Prototype\Graylog;

use OctoLab\Observer;
use OctoLab\Observer\Payload;
use OctoLab\Observer\Type;

class Classifier implements Observer\Classifier
{
    private const LIMIT = 10;

    public function classify(\Throwable $e, ?Payload\Context $context = null): Type\Action
    {
        return match ($e::class) {
            \DomainException::class => new Type\Action(
                $context?->attempt() < self::LIMIT ? Type\Flow::repeat : Type\Flow::ignore,
                message: '{name} integration example',
            ),
            default => new Type\Action(Type\Flow::throw),
        };
    }
}
