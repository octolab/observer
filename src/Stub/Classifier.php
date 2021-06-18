<?php

declare(strict_types=1);

namespace OctoLab\Observer\Stub;

use JetBrains\PhpStorm\Pure;
use OctoLab\Observer;
use OctoLab\Observer\Type;

class Classifier implements Observer\Classifier
{
    #[Pure] public function classify(\Throwable $error): Type\Action
    {
        return new Type\Action($error, Type\Flow::ignore);
    }
}
