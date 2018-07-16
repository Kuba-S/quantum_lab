<?php
declare(strict_types=1);

namespace QL\Domain\Person\Command;

use QL\Application\Mappable;

class RemovePersonCommand implements Mappable
{
    /**
     * @var string
     */
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public static function fromCliParams(array $params): RemovePersonCommand
    {
        if (count($params) !== 1) {
            throw new \InvalidArgumentException('Invalid number of arguments, must be "1". Given: ' . count($params) . '.');
        }
        return new static($params[0]);
    }
}
