<?php
declare(strict_types=1);

namespace QL\Domain\Person\Infrastructure;

use QL\Domain\Person\DomainModel\Person;
use QL\Domain\Person\DomainModel\ProgrammingLanguage;
use QL\Infrastructure\Repository;

class PersonRepository
{
    /**
     * @var Repository
     */
    private $repository;

    public function __construct(Repository $jsonRepository)
    {
        $this->repository = $jsonRepository;
    }

    public function getAllPeople(): array
    {
        return $this->searchPerson();
    }

    public function searchPersonByName(string $name = null)
    {
        return $this->searchPerson('name', $name);
    }

    private function searchPerson(string $parameterName = null, string $searchValue = null)
    {
        $personList = [];
        if ($parameterName === null) {
            $people = $this->repository->getAll(TableNamesStrategy::PERSON_KEY);
        } else {
            $people = $this->repository->findBy(TableNamesStrategy::PERSON_KEY, 'name', $searchValue, true);
        }
        foreach ($people as $person) {
            $programmingLanguages = [];
            $personProgrammingLanguageRelation = $this->repository->findBy(TableNamesStrategy::PERSON_PROGRAMMING_LANGUAGE_RELATION_KEY, 'person_id', $person['id']);
            foreach ($personProgrammingLanguageRelation as $relation) {
                $languagesList = $this->repository->findBy(TableNamesStrategy::PROGRAMMING_LANGUAGE_KEY, 'id', $relation['programming_language_id']);
                $programmingLanguages[] = ProgrammingLanguage::fromArray($languagesList[0]);
            }
            $personList[] = new Person($person['id'], $person['name'], $programmingLanguages);
        }
        return $personList;
    }

    public function searchPersonByProgrammingLanguage(array $programmingLanguagesList): array
    {
        // TODO: Implement search() method.
    }

    public function persist(object $object)
    {
        $persistStrategy = new CommandStrategy($object);
        foreach ($persistStrategy->dataToPersist() as $data) {
            $this->repository->add($data['tableName'], $data['data']);
        }
        $this->repository->flush();
        return $object;
    }

    public function update(object $object)
    {
        // TODO: Implement update() method.

    }

    public function remove(object $object)
    {
        $tableValues = new TableNamesStrategy($object);
        $this->repository->delete($tableValues->getTableKey(), 'id', $object->getId());
        $this->repository->flush();
    }

    public function getProgrammingLanguageByName(string $name): ?ProgrammingLanguage
    {
        $languagesList = $this->repository->findBy(TableNamesStrategy::PROGRAMMING_LANGUAGE_KEY, 'name', $name, false);
        if (empty($languagesList)) {
            return null;
        } else {
            return ProgrammingLanguage::fromArray($languagesList[0]);
        }
    }

}
