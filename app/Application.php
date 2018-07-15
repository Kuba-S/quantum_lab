<?php
declare(strict_types=1);

use QL\Command\CliRequest;
use QL\Command\Mappable;
use QL\Command\Validator;
use QL\Domain\Person\Infrastructure\PersonRepository;
use QL\Formatter\Formatter;
use QL\Infrastructure\Repository;

class Application
{
    private const CONFIG_FILE = 'app/config.json';
    private const ROUTING_FILE = 'app/routing.json';
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
            if (!isset($this->routing[self::CLI_ROUTING_PARAMETER][$cliRequest->getCommandName()])) {
                throw new \InvalidArgumentException('No defined routing for command "' . $cliRequest->getCommandName() . '".');
            }

            if (!isset($this->routing[self::CLI_ROUTING_PARAMETER][$cliRequest->getCommandName()]['class'])) {
                throw new \InvalidArgumentException('No defined handler for routing "' . $cliRequest->getCommandName() . '".');
            }

            if (!isset($this->routing[self::CLI_ROUTING_PARAMETER][$cliRequest->getCommandName()]['method'])) {
                throw new \InvalidArgumentException('No defined method for routing "' . $cliRequest->getCommandName() . '".');
            }

            $handlerClass = $this->routing[self::CLI_ROUTING_PARAMETER][$cliRequest->getCommandName()]['class'];
            $handlerMethod = $this->routing[self::CLI_ROUTING_PARAMETER][$cliRequest->getCommandName()]['method'];
            $methodArguments = $this->routing[self::CLI_ROUTING_PARAMETER][$cliRequest->getCommandName()]['mapTo'] ?? $cliRequest->getArguments();
            $validatorClassName = $this->routing[self::CLI_ROUTING_PARAMETER][$cliRequest->getCommandName()]['validator'] ?? null;
            $handlerClassInstance = new $handlerClass(new PersonRepository($this->repository));
            $handlerMethod .= 'Action';

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

    private function loadConfiguration(): void
    {
        $this->config = $this->readJsonFile(self::CONFIG_FILE);
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

    public function getConfig(): array
    {
        return $this->config;
    }

    private function presentOutput($message): void
    {
        $outputResource = fopen('php://output', 'w');
        if (false === @fwrite($outputResource, $message . PHP_EOL)) {
            throw new RuntimeException('Unable to write output.');
        }

        fflush($outputResource);
    }

}
