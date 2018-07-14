<?php
declare(strict_types=1);

namespace QL\Domain\Person\DomainModel;

class ProgrammingLanguage
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    public function __construct(string $id, string $name)
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
        return new static(md5((string) mt_rand()), $name);
    }


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
}
