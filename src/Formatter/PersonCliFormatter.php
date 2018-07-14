<?php
declare(strict_types=1);

namespace QL\Formatter;

use QL\Domain\Person\DomainModel\Person;
use QL\Domain\Person\DomainModel\ProgrammingLanguage;

class PersonCliFormatter implements Formatter
{
    /**
     * @param Person $person
     * @return string
     */
    public function formatOne($person): string
    {
        $responseString = $person->getName();
        /** @var ProgrammingLanguage $programmingLanguage */
        $responseLanguagesList = [];
        foreach ($person->getProgrammingLanguages() as $programmingLanguage) {
            $responseLanguagesList[] = $programmingLanguage->getName();
        }
        return $responseString . ' - (' . implode(', ', $responseLanguagesList) . ')';
    }

    /**
     * @param Person[] $personList
     */
    public function formatMany(array $personList): string
    {
        $response = [];
        foreach ($personList as $person) {
            $response[] = $this->formatOne($person);
        }
        return implode(PHP_EOL, $response);
    }
}
