<?php

require __DIR__ . '/vendor/autoload.php';

use OctoLab\Observer\Bricks as Prototype;
use OctoLab\Observer\Bricks\Graylog\Fields;

// arrange
$graylog = new Gelf\Logger(
    new Gelf\Publisher(
        new Gelf\Transport\UdpTransport('127.0.0.1', 12201),
        new Gelf\MessageValidator(),
    ),
);
$observer = new OctoLab\Observer\Facade(logger: new Prototype\Graylog\Logger($graylog));



// domain
$revolver = [
    new OverflowException(),
    new RuntimeException(),
    new DomainException(),
    new LogicException(),
    new OctoLab\Observer\Exception\Broken(new BadMethodCallException()),
];
$action = static function () use ($revolver): array {
    static $attempts = 0;
    throw $revolver[$attempts++ % count($revolver)];
};
$context = static function (OctoLab\Observer\Simple\Limiter $limiter): OctoLab\Observer\Simple\Context {
    return new OctoLab\Observer\Simple\Context([
        Fields::NAME => 'Graylog',
        Fields::ATTEMPT => $limiter->attempt(),
    ]);
};
$classifier = new Prototype\Graylog\Classifier();



// act
$limiter = new OctoLab\Observer\Simple\Limiter(2 * count($revolver));
while ($limiter->pass()) {
    try {
        $result = $action();
    } catch (Throwable $e) {
        $repeat = $observer->handle($classifier->classify($e), $context($limiter));
        $limiter->break(!$repeat);
    }

    // assert
    print 'repeat? ' . ($limiter->continue() ? 'yes' : 'no') . PHP_EOL;
}
