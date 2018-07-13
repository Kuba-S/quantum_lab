<?php
declare(strict_types=1);

use QL\Command\CliRequest;
use QL\Command\Mappable;

class Application
{
    private const CONFIG_FILE = 'app/config.json';
    private const ROUTING_FILE = 'app/routing.json';
    private const CLI_ROUTING_PARAMETER = 'cli';

    private $config = [];

    private $routing = [];

    public function __construct()
    {
        $this->loadConfiguration();
        $this->loadRouting();
    }

    public function handleCliRequest(CliRequest $cliRequest)
    {
        if (!isset($this->routing[self::CLI_ROUTING_PARAMETER][$cliRequest->getCommandName()])) {
            $this->presentOutput('No defined routing for command "' . $cliRequest->getCommandName() . '"');
        }

        if (!isset($this->routing[self::CLI_ROUTING_PARAMETER][$cliRequest->getCommandName()]['class'])) {
            $this->presentOutput('No defined handler for routing "' . $cliRequest->getCommandName() . '"');
        }

        if (!isset($this->routing[self::CLI_ROUTING_PARAMETER][$cliRequest->getCommandName()]['method'])) {
            $this->presentOutput('No defined method for routing "' . $cliRequest->getCommandName() . '"');
        }

        $handlerClass = $this->routing[self::CLI_ROUTING_PARAMETER][$cliRequest->getCommandName()]['class'];
        $handlerMethod = $this->routing[self::CLI_ROUTING_PARAMETER][$cliRequest->getCommandName()]['method'];
        $methodArguments = $this->routing[self::CLI_ROUTING_PARAMETER][$cliRequest->getCommandName()]['mapTo'] ?? $cliRequest->getArguments();

        $handlerClassInstance = new $handlerClass();
        $handlerMethod .= 'Action';

        if ($methodArguments && is_a((string) $methodArguments, Mappable::class, true)) {
            $methodArguments = $methodArguments::fromCliParams($cliRequest->getArguments());
        }

        $response = $handlerClassInstance->$handlerMethod($methodArguments);
        $this->presentOutput($response);
    }

    private function loadConfiguration(): void
    {
        $this->config = $this->readJsonFile(self::CONFIG_FILE);
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    private function loadRouting(): void
    {
        $this->routing = $this->readJsonFile(self::ROUTING_FILE);
    }

    private function readJsonFile(string $file): ?array
    {
        $configFileContent = file_get_contents(__DIR__ . '/../' . $file);
        return json_decode($configFileContent, true);
    }

    private function presentOutput($message)
    {
        $outputResource = fopen('php://output', 'w');
        if (false === @fwrite($outputResource, $message . PHP_EOL)) {
            throw new RuntimeException('Unable to write output.');
        }

        fflush($outputResource);
    }

}
