<?php

declare(strict_types=1);

namespace OctoLab\Observer;

interface Classifier
{
    public function classify(\Throwable $exception): Type\Action;
}
