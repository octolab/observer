<?php

declare(strict_types=1);

namespace OctoLab\Observer\Stub;

use OctoLab\Observer;

class Debugger implements Observer\Debugger
{
    public function debug(\Throwable $error): void
    {
    }
}
