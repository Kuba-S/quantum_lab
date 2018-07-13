<?php
declare(strict_types=1);

namespace QL\Domain\Person\DomainModel;

class ProgrammingLanguage
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function fromArray($language)
    {
        return new static($language['id'], $language['name']);
    }

    public static function create($name): ProgrammingLanguage
    {
        return new static(rand(1, 10000000), $name);
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
}
