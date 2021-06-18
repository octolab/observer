<?php

declare(strict_types=1);

namespace OctoLab\Observer\Bricks\Sentry;

enum Fields: string
{
    final public const ATTEMPT = 'attempt';
    final public const NAME = 'name';
}
