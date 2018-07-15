<?php
declare(strict_types=1);

namespace QL\Domain\Person\ReadModel;

use QL\Command\Mappable;

class FindPersonByProgrammingLanguagesQuery implements Mappable
{
    private $programmingLanguages = [];

    public function __construct(array $programmingLanguages)
    {
        $this->programmingLanguages = $programmingLanguages;
    }

    public function getProgrammingLanguages(): array
    {
        return $this->programmingLanguages;
    }

    public static function fromCliParams(array $params): FindPersonByProgrammingLanguagesQuery
    {
        if (count($params) < 1) {
            throw new \InvalidArgumentException('Invalid number of parameters. Must be at least "1". Given: ' . count($params) . '.');
        }

        return new self($params);
    }
}
