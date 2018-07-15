<?php
declare(strict_types=1);

namespace QL\Domain\Person\Command;

use QL\Command\Mappable;

class RemoveProgrammingLanguageCommand implements Mappable
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function fromCliParams(array $params)
    {
        return new static($params[0]);
    }
}
