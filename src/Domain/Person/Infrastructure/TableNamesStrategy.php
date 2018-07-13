<?php
declare(strict_types=1);

namespace QL\Domain\Person\Infrastructure;

use QL\Domain\Person\DomainModel\Person;
use QL\Domain\Person\DomainModel\ProgrammingLanguage;

class TableNamesStrategy
{
    public const PERSON_KEY = 'person';
    public const PERSON_PROGRAMMING_LANGUAGE_RELATION_KEY = 'person_programming_languages';
    public const PROGRAMMING_LANGUAGE_KEY = 'programming_languages';

    private $tableKey;

    public function __construct(object $object)
    {
        if ($object instanceof Person) {
            $this->tableKey = self::PERSON_KEY;
        } elseif ($object instanceof ProgrammingLanguage) {
            $this->tableKey = self::PROGRAMMING_LANGUAGE_KEY;
        }
    }

    public function getPersonProgrammingLanguageKey(): string
    {
        return self::PERSON_PROGRAMMING_LANGUAGE_RELATION_KEY;
    }

    public function getTableKey(): string
    {
        return $this->tableKey;
    }
}
