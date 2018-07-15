<?php
declare(strict_types=1);

namespace QL\Domain\Person\DomainModel;

class Person
{
    /**
     * @var string
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

    /**
     * @param ProgrammingLanguage[] $programmingLanguages
     */
    public function __construct(string $id, string $name, array $programmingLanguages)
    {
        $this->id = $id;
        $this->name = $name;
        $this->programmingLanguages = $programmingLanguages;
    }

    /**
     * @param ProgrammingLanguage[] $programmingLanguages
     */
    public static function create(string $name, array $programmingLanguages)
    {
        return new self(md5((string) mt_rand()), $name, $programmingLanguages);
    }

    /**
     * @return string
     */
    public function getId(): string
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
     * @return ProgrammingLanguage[]
     */
    public function getProgrammingLanguages(): array
    {
        return $this->programmingLanguages;
    }
}
