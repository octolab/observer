<?php

declare(strict_types=1);

namespace OctoLab\Observer\Type;

enum Flow
{
    case ignore;
    case repeat;
    case break;
    case throw;
}
