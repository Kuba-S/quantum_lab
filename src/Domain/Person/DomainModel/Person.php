<?php
declare(strict_types=1);

class Person
{
    /**
     * @var int
     */
    private $id;

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
    private $programmingLanguages;

    public function __construct(int $id, string $firstName, string $lastName, array $programmingLanguages)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->programmingLanguages = $programmingLanguages;
        $this->id = $id;
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
    public function getProgrammingLanguages(): array
    {
        return $this->programmingLanguages;
    }
}
