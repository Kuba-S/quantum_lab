<?php
declare(strict_types=1);

namespace QL\Domain\Person\DomainModel;

class Person
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $programmingLanguages;

    public function __construct(int $id, string $name, array $programmingLanguages)
    {
        $this->id = $id;
        $this->name = $name;
        $this->programmingLanguages = $programmingLanguages;
    }

    public static function create(string $name, array $programmingLanguages)
    {
        return new self(rand(1, 10000000), $name, $programmingLanguages);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getProgrammingLanguages(): array
    {
        return $this->programmingLanguages;
    }
}
