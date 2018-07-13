<?php
declare(strict_types=1);

namespace QL\Domain\Person\Command;

use QL\Command\Mappable;

class AddPersonCommand implements Mappable
{
    /**
     * @var string
     */
    private $firstName;
    /**
     * @var string
     */
    private $lastName;
    /**
     * @var array
     */
    private $programmingLanguageList;

    public function __construct(string $firstName, string $lastName, array $programmingLanguageList)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->programmingLanguageList = $programmingLanguageList;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return array
     */
    public function getProgrammingLanguageList(): array
    {
        return $this->programmingLanguageList;
    }

    public static function fromCliParams(array $params)
    {
        if (count($params) < 3) {
            throw new \InvalidArgumentException('Invalid number of arguments, must be at least 3. Given: ' . count($params) . '.');
        }
        return new static(array_shift($params), array_shift($params), $params);
    }
}
