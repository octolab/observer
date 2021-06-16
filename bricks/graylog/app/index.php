<?php

require __DIR__ . '/../vendor/autoload.php';

$logger = new Gelf\Logger(
    new Gelf\Publisher(
        new Gelf\Transport\UdpTransport('127.0.0.1', 12201),
        new Gelf\MessageValidator(),
    ),
);

$observer = new OctoLab\Observer\Facade(
    classifier: new Prototype\Graylog\Classifier(),
    logger: new Prototype\Graylog\Logger($logger),
);

$context = new Prototype\Graylog\Context(['name' => 'Graylog']);
$repeat = true;
while ($repeat) {
    $repeat = $observer->handle(new DomainException(), $context);
    print 'repeat? ' . ($repeat ? 'yes' : 'no') . PHP_EOL;
}
