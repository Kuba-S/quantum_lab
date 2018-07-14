<?php
declare(strict_types=1);

use QL\Command\CliRequest;
use QL\Infrastructure\JsonRepository;

set_time_limit(0);

require __DIR__ . '/vendor/autoload.php';

$cliRequest = CliRequest::fromArgv($argv);

$application = new Application();
$repository = new JsonRepository($application->getConfig()['db']['file']);
$application->setRepository($repository);

$application->handleCliRequest(CliRequest::fromArgv($argv));
