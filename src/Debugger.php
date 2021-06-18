<?php

declare(strict_types=1);

namespace OctoLab\Observer;

interface Debugger
{
    public function debug(\Throwable $error): void;
}
