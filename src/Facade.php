<?php

declare(strict_types=1);

namespace OctoLab\Observer;

class Facade
{
    public function __construct(
        private readonly Analytics $analytics = new Stub\Analytics(),
        private readonly Classifier $classifier = new Stub\Classifier(),
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

    public function handle(\Throwable $e, ?Payload\Context $context = null): bool
    {
        $action = $this->classifier->classify($e, $context);
        if ($action->logIsNeeded()) {
            $this->logger->log($action->severity, $action->message, $context);
        }
        if ($action->countIsNeeded()) {
            $this->telemetry->count($action->metric, context: $context);
        }
        return match ($action->flow) {
            Type\Flow::ignore => false,
            Type\Flow::repeat => true,
            Type\Flow::break => throw new Exception\Broken($e),
            Type\Flow::throw => throw $e,
        };
    }
}
