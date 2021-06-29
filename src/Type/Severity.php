<?php

declare(strict_types=1);

namespace OctoLab\Observer\Type;

enum Severity: int
{
    case Emergency = 0;
    case Alert = 1;
    case Critical = 2;
    case Error = 3;
    case Warning = 4;
    case Notice = 5;
    case Info = 6;
    case Debug = 7;

    public function isHigher(self $severity): bool
    {
        return $this->value < $severity->value;
    }

    public function isLower(self $severity): bool
    {
        return $this->value > $severity->value;
    }
}
