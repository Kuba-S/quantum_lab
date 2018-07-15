<?php
declare(strict_types=1);

namespace QL\Formatter;

use QL\Domain\Person\DomainModel\ProgrammingLanguage;

class ProgrammingLanguageCliFormatter implements Formatter
{
    /**
     * @param ProgrammingLanguage $programmingLanguage
     */
    public function formatOne($programmingLanguage): string
    {
        return $programmingLanguage->getName();
    }

    /**
     * @param ProgrammingLanguage[] $objectList
     */
    public function formatMany(array $programmingLanguagesList): string
    {
        $response = [];
        foreach ($programmingLanguagesList as $programmingLanguage) {
            $response[] = $this->formatOne($programmingLanguage);
        }
        return implode(PHP_EOL, $response);
    }
}
