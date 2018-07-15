<?php
declare(strict_types=1);

namespace QL\Domain\Person\ReadModel;

use QL\Command\Mappable;

class FindPersonByNameQuery implements Mappable
{
    /**
     * @var string
     */
    private $searchString;

    public function __construct(string $searchString)
    {
        $this->searchString = $searchString;
    }

    /**
     * @return null|string
     */
    public function getSearchString(): string
    {
        return $this->searchString;
    }

    public static function fromCliParams(array $params): FindPersonByNameQuery
    {
        if (count($params) !== 1) {
            throw new \InvalidArgumentException('Invalid number of parameters. Must be "1". Given: ' . count($params) . '.');
        }

        return new self($params[0]);
    }
}
