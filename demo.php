<?php
declare(strict_types=1);

use QL\Command\CliRequest;

set_time_limit(0);

require __DIR__ . '/vendor/autoload.php';

$cliRequest = CliRequest::fromArgv($argv);

$application = new Application();
$application->handleCliRequest(CliRequest::fromArgv($argv));
