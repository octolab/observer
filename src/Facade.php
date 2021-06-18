<?php

declare(strict_types=1);

namespace OctoLab\Observer;

use JetBrains\PhpStorm\Pure;

class Facade
{
    #[Pure] public function __construct(
        private readonly Analytics $analytics = new Stub\Analytics(),
        private readonly Debugger $debugger = new Stub\Debugger(),
        private readonly Logger $logger = new Stub\Logger(),
        private readonly Telemetry $telemetry = new Stub\Telemetry(),
        private readonly Tracer $tracer = new Stub\Tracer(),
    )
    {
    }

    public function analytics(): Analytics
    {
        return $this->analytics;
    }

    public function debugger(): Debugger
    {
        return $this->debugger;
    }

    public function logger(): Logger
    {
        return $this->logger;
    }

    public function telemetry(): Telemetry
    {
        return $this->telemetry;
    }

    public function tracer(): Tracer
    {
        return $this->tracer;
    }

    public function handle(Type\Action $action, ?Payload\Context $context = null): bool
    {
        if ($action->countIsNeeded()) {
            $this->telemetry->count($action->metric, context: $context);
        }
        if ($action->debugIsNeeded()) {
            $this->debugger->debug($action->error);
        }
        if ($action->logIsNeeded()) {
            $this->logger->log($action->severity, $action->message, $context);
        }
        return match ($action->flow) {
            Type\Flow::ignore => false,
            Type\Flow::repeat => true,
            Type\Flow::throw => throw $action->error,
            Type\Flow::break => throw new Exception\Broken($action->error),
        };
    }
}
