<?php
declare(strict_types=1);

namespace QL\Application;

class CliRequest
{
    /**
     * @var string
     */
    private $commandName;

    /**
     * @var array
     */
    private $arguments;

    public function __construct(string $commandName, array $arguments = null)
    {
        $this->commandName = $commandName;
        $this->arguments = $arguments;
    }

    public static function fromArgv(array $argv): CliRequest
    {
        $commandName = $argv[1] ?? '';
        $args = array_slice($argv, 2);

        return new static($commandName, $args);
    }

    /**
     * @return string
     */
    public function getCommandName(): string
    {
        return $this->commandName;
    }

    /**
     * @return array
     */
    public function getArguments(): ?array
    {
        return $this->arguments;
    }
}
