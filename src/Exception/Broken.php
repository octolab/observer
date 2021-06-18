<?php

declare(strict_types=1);

namespace OctoLab\Observer\Exception;

use JetBrains\PhpStorm\Pure;

class Broken extends \RuntimeException
{
    final public const CODE = 500;
    final public const MESSAGE = 'Interrupted execution flow';

    #[Pure] public function __construct(\Throwable $error)
    {
        parent::__construct(self::MESSAGE, self::CODE, $error);
    }
}
