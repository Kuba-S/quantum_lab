<?php
declare(strict_types=1);

namespace QL\Domain\Person\Infrastructure;

use QL\Domain\Person\DomainModel\Person;
use QL\Domain\Person\DomainModel\ProgrammingLanguage;

class RelationsStrategy
{
    /**
     * @var object
     */
    private $object;

    public function __construct(object $object)
    {
        $this->object = $object;
    }

    public function add(): array
    {
        if ($this->object instanceof Person) {
            $dataToPersist = [
                [
                    'tableName' => PersonRepository::PERSON_TABLE_NAME,
                    'data' => ['id' => $this->object->getId(), 'name' => $this->object->getName()],
                ]
            ];
            /** @var ProgrammingLanguage $programmingLanguage */
            foreach ($this->object->getProgrammingLanguages() as $programmingLanguage) {
                $dataToPersist[] = [
                    'tableName' => PersonRepository::PERSON_PROGRAMMING_LANGUAGE_RELATION_TABLE_NAME,
                    'data' => ['person_id' => $this->object->getId(), 'programming_language_id' => $programmingLanguage->getId()],
                ];
            }
            return $dataToPersist;
        } elseif ($this->object instanceof ProgrammingLanguage) {
            return [
                [
                    'tableName' => PersonRepository::PROGRAMMING_LANGUAGE_TABLE_NAME,
                    'data' => ['id' => $this->object->getId(), 'name' => $this->object->getName()],
                ]
            ];
        }
    }

    public function remove(): array
    {
        if ($this->object instanceof Person) {
            $dataToPersist = [
                [
                    'tableName' => PersonRepository::PERSON_TABLE_NAME,
                    'data' => ['parameter' => 'id', 'value' => $this->object->getId()],
                ],
                [
                    'tableName' => PersonRepository::PERSON_PROGRAMMING_LANGUAGE_RELATION_TABLE_NAME,
                    'data' => ['parameter' => 'person_id', 'value' => $this->object->getId()],
                ]
            ];
            return $dataToPersist;
        } elseif ($this->object instanceof ProgrammingLanguage) {
            return [
                [
                    'tableName' => PersonRepository::PROGRAMMING_LANGUAGE_TABLE_NAME,
                    'data' => ['parameter' => 'id', 'value' => $this->object->getId()],
                ]
            ];
        }
    }
}
