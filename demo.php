#!/usr/bin/php
<?php
declare(strict_types=1);

use QL\Application\Application;
use QL\Application\CliRequest;
use QL\Infrastructure\JsonRepository;

set_time_limit(0);

require __DIR__ . '/src/autoload.php';

$cliRequest = CliRequest::fromArgv($argv);

$application = new Application();
$repository = new JsonRepository($application->getConfig()['db']['file']);
$application->setRepository($repository);

$application->handleCliRequest(CliRequest::fromArgv($argv));
