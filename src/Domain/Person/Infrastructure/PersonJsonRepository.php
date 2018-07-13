<?php
declare(strict_types=1);

namespace QL\Domain\Person\Infrastructure;

use QL\Domain\Person\Command\CommandPersonRepository;
use QL\Domain\Person\DomainModel\ProgrammingLanguage;
use QL\Domain\Person\ReadModel\PersonRepository;
use QL\Infrastructure\JsonRepository;

class PersonJsonRepository implements PersonRepository, CommandPersonRepository
{
    /**
     * @var JsonRepository
     */
    private $jsonRepository;

    public function __construct(JsonRepository $jsonRepository)
    {
        $this->jsonRepository = $jsonRepository;
    }

    public function getAllPeople(): array
    {
        $people = $this->jsonRepository->getAll(TableNamesStrategy::PERSON_KEY);
        $peapleProgrammingLanguageRelation = $this->jsonRepository->getAll(TableNamesStrategy::PERSON_PROGRAMMING_LANGUAGE_RELATION_KEY);
        $programmingLanguages = $this->jsonRepository->getAll(TableNamesStrategy::PROGRAMMING_LANGUAGE_KEY);
        // TODO: Implement merge.
    }

    public function search(): array
    {
        // TODO: Implement search() method.
    }

    public function persist(object $object)
    {
        $persistStrategy = new AddStrategy($object);
        foreach ($persistStrategy->dataToPersist() as $data) {
            $this->jsonRepository->add($data['tableName'], $data['data']);
        }
        $this->jsonRepository->flush();
        return $object;
    }

    public function update(object $object)
    {
        // TODO: Implement update() method.

    }

    public function remove(object $object)
    {
        $tableValues = new TableNamesStrategy($object);
        $this->jsonRepository->delete($tableValues->getTableKey(), 'id', $object->getId());
        $this->jsonRepository->flush();
    }

    public function getProgrammingLanguageByName(string $name): ?ProgrammingLanguage
    {
        $languagesList = $this->jsonRepository->findBy(TableNamesStrategy::PROGRAMMING_LANGUAGE_KEY, 'name', $name, false);
        if (empty($languagesList)) {
            return null;
        } else {
            return ProgrammingLanguage::fromArray($languagesList[0]);
        }
    }
}
