<?php

declare(strict_types=1);

namespace OctoLab\Observer\Payload;

use OctoLab\Observer\Type;

interface Classifier
{
    public function classify(\Throwable $error): Type\Action;
}
