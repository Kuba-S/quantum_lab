<?php
declare(strict_types=1);

namespace QL\Application;

use QL\Domain\Person\Infrastructure\PersonRepository;
use QL\Formatter\Formatter;
use QL\Infrastructure\Repository;

class Application
{
    private const CONFIG_FILE = '/../../config/config.json';
    private const ROUTING_FILE = '/../../config/routing.json';
    private const CLI_ROUTING_PARAMETER = 'cli';

    private $config = [];

    private $routing = [];

    private $repository;

    public function __construct()
    {
        $this->loadConfiguration();
        $this->loadRouting();
    }

    public function setRepository(Repository $repository): void
    {
        $this->repository = $repository;
    }

    public function handleCliRequest(CliRequest $cliRequest): void
    {
        try {
            $this->validateRequireRoutingFields(self::CLI_ROUTING_PARAMETER, $cliRequest->getCommandName());

            $handlerClassName = $this->routing[self::CLI_ROUTING_PARAMETER][$cliRequest->getCommandName()]['class'];
            $handlerMethod = $this->routing[self::CLI_ROUTING_PARAMETER][$cliRequest->getCommandName()]['method'];
            $methodArguments = $this->routing[self::CLI_ROUTING_PARAMETER][$cliRequest->getCommandName()]['mapTo'] ?? $cliRequest->getArguments();
            $validatorClassName = $this->routing[self::CLI_ROUTING_PARAMETER][$cliRequest->getCommandName()]['validator'] ?? null;
            $handlerClassInstance = new $handlerClassName(new PersonRepository($this->repository));

            if ($methodArguments && is_a((string)$methodArguments, Mappable::class, true)) {
                /** @var Mappable $methodArguments */
                $methodArguments = $methodArguments::fromCliParams($cliRequest->getArguments());
            }

            if ($validatorClassName && is_a((string)$validatorClassName, Validator::class, true)) {
                /** @var Validator $validator */
                $validator = new $validatorClassName($methodArguments);
                $validator->validate();
            }

            $response = $handlerClassInstance->$handlerMethod($methodArguments);

            $formatterClassName = $this->routing[self::CLI_ROUTING_PARAMETER][$cliRequest->getCommandName()]['formatter'] ?? null;
            if ($formatterClassName && is_a((string) $formatterClassName, Formatter::class, true)) {
                /** @var Formatter $formatter */
                $formatter = new $formatterClassName();
                $response = is_array($response) ? $formatter->formatMany($response) : $formatter->formatOne($response);
            }
        } catch (\InvalidArgumentException $e) {
            $response = $e->getMessage();
        }

        $this->presentOutput($response);
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    private function validateRequireRoutingFields(string $requestType, string $commandName): void
    {
        if (!isset($this->routing[$requestType][$commandName])) {
            throw new \InvalidArgumentException('No defined routing for command "' . $commandName . '".');
        }

        if (!isset($this->routing[$requestType][$commandName]['class'])) {
            throw new \InvalidArgumentException('No defined handler for routing "' . $commandName . '".');
        }

        if (!isset($this->routing[$requestType][$commandName]['method'])) {
            throw new \InvalidArgumentException('No defined method for routing "' . $commandName . '".');
        }
    }

    private function loadConfiguration(): void
    {
        $this->config = $this->readJsonFile(__DIR__ . self::CONFIG_FILE);
    }

    private function loadRouting(): void
    {
        $this->routing = $this->readJsonFile(__DIR__ . self::ROUTING_FILE);
    }

    private function readJsonFile(string $file): ?array
    {
        $configFileContent = file_get_contents($file);
        return json_decode($configFileContent, true);
    }

    private function presentOutput($message): void
    {
        $outputResource = fopen('php://output', 'w');
        if (false === @fwrite($outputResource, $message . PHP_EOL)) {
            throw new \RuntimeException('Unable to write output.');
        }

        fflush($outputResource);
    }
}
