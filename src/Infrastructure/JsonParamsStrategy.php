<?php
declare(strict_types=1);

namespace QL\Infrastructure;

use QL\Domain\Person\DomainModel\Person;
use QL\Domain\Person\DomainModel\ProgrammingLanguage;

class JsonParamsStrategy
{
    public const PERSON_KEY = 'person';
    public const PERSON_PROGRAMMING_LANGUAGE_RELATION_KEY = 'person_programming_languages';
    public const PROGRAMMING_LANGUAGE_KEY = 'programming_languages';

    private $jsonKey = '';

    public function __construct(object $object)
    {
        if ($object instanceof Person) {
            $this->jsonKey = self::PERSON_KEY;
        } elseif ($object instanceof ProgrammingLanguage) {
            $this->jsonKey = self::PROGRAMMING_LANGUAGE_KEY;
        }
    }

    public function getPersonProgrammingLanguageKey(): string
    {
        return self::PERSON_PROGRAMMING_LANGUAGE_RELATION_KEY;
    }

    public function getKey(): string
    {
        return $this->jsonKey;
    }
}
