<?php

declare(strict_types=1);

namespace OctoLab\Observer\Simple;

use JetBrains\PhpStorm\Pure;
use OctoLab\Observer\Payload;
use OctoLab\Observer\Type;

class Classifier implements Payload\Classifier
{
    #[Pure] public function classify(\Throwable $error): Type\Action
    {
        return new Type\Action($error, Type\Flow::ignore);
    }
}
