<?php

declare(strict_types=1);

namespace OctoLab\Observer\Exception;

class Broken extends \RuntimeException
{
    final public const CODE = 500;
    final public const MESSAGE = 'Interrupted execution flow';

    public function __construct(\Throwable $e)
    {
        parent::__construct(self::MESSAGE, self::CODE, $e);
    }
}
