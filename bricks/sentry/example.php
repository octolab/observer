<?php

require __DIR__ . '/vendor/autoload.php';

use OctoLab\Observer\Bricks as Prototype;
use OctoLab\Observer\Bricks\Graylog\Fields;

// arrange
$sentry = new Sentry\State\Hub(
    Sentry\ClientBuilder::create([
        'dsn' => getenv('SENTRY_DSN'),
    ])->getClient()
);
$observer = new OctoLab\Observer\Facade(logger: new Prototype\Sentry\Logger($sentry));



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
        Fields::NAME => 'Sentry',
        Fields::ATTEMPT => $limiter->attempt(),
    ]);
};
$classifier = new Prototype\Sentry\Classifier();



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
