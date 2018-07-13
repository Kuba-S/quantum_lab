<?php
declare(strict_types=1);

namespace QL\Domain\Person\Infrastructure;

use QL\Domain\Person\DomainModel\Person;
use QL\Domain\Person\DomainModel\ProgrammingLanguage;

class AddStrategy
{
    /**
     * @var object
     */
    private $object;

    public function __construct(object $object)
    {
        $this->object = $object;
    }

    public function dataToPersist()
    {
        if ($this->object instanceof Person) {
            $dataToPersist = [
                [
                    'tableName' => TableNamesStrategy::PERSON_KEY,
                    'data' => ['id' => $this->object->getId(), 'name' => $this->object->getName()],
                ]
            ];
            /** @var ProgrammingLanguage $programmingLanguage */
            foreach ($this->object->getProgrammingLanguages() as $programmingLanguage) {
                $dataToPersist[] = [
                    'tableName' => TableNamesStrategy::PERSON_PROGRAMMING_LANGUAGE_RELATION_KEY,
                    'data' => ['id' => $this->object->getId(), 'person_id' => $this->object->getId(), 'programming_language_id' => $programmingLanguage->getId()],
                ];
            }
            return $dataToPersist;
        } elseif ($this->object instanceof ProgrammingLanguage) {
            return [
                [
                    'tableName' => TableNamesStrategy::PROGRAMMING_LANGUAGE_KEY,
                    'data' => ['id' => $this->object->getId(), 'name' => $this->object->getName()],
                ]
            ];
        }
    }
}