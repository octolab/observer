<?php

require __DIR__ . '/../vendor/autoload.php';

use OctoLab\Observer\Bricks as Prototype;

// arrange
$logger = new Gelf\Logger(
    new Gelf\Publisher(
        new Gelf\Transport\UdpTransport('127.0.0.1', 12201),
        new Gelf\MessageValidator(),
    ),
);
$observer = new OctoLab\Observer\Facade(logger: new Prototype\Graylog\Logger($logger));

// domain
$action = static fn(): array => throw new DomainException();
$classifier = new Prototype\Graylog\Classifier();

// act
$limiter = new Prototype\Graylog\Limiter(3);
while ($limiter->pass()) {
    $context = new Prototype\Graylog\Context([
        'name' => 'Graylog',
        'attempt' => $limiter->attempt(),
    ]);
    try {
        $result = $action();
    } catch (DomainException $e) {
        $repeat = $observer->handle($classifier->classify($e), $context->with($e));
        $limiter->break(!$repeat);
    }

    // assert
    print 'repeat? ' . ($limiter->continue() ? 'yes' : 'no') . PHP_EOL;
}
