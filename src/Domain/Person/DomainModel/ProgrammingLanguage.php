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
