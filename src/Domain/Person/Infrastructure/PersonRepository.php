<?php
declare(strict_types=1);

namespace QL\Domain\Person\Infrastructure;

use QL\Domain\Person\DomainModel\Person;
use QL\Domain\Person\DomainModel\ProgrammingLanguage;
use QL\Infrastructure\Repository;

class PersonRepository
{
    public const PERSON_TABLE_NAME = 'person';

    public const PERSON_PROGRAMMING_LANGUAGE_RELATION_TABLE_NAME = 'person_programming_languages';

    public const PROGRAMMING_LANGUAGE_TABLE_NAME = 'programming_languages';

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

    public function searchPersonByName(string $name = null): array
    {
        return $this->searchPerson('name', $name);
    }

    public function getPersonById(string $id): Person
    {
        $person = $this->repository->findBy(static::PERSON_TABLE_NAME, 'id', $id, true);
        if (!empty($person)) {
            return $this->buildPersonWithRelations(array_shift($person));
        }
        throw new \LogicException('Person with Id: ' . $id . ' doesn\'t exists.');
    }

    private function searchPerson(string $parameterName = null, string $searchValue = null): array
    {
        if ($parameterName === null) {
            $people = $this->repository->getAll(static::PERSON_TABLE_NAME);
        } else {
            $people = $this->repository->findBy(static::PERSON_TABLE_NAME, 'name', $searchValue, true);
        }
        $personList = [];
        foreach ($people as $person) {
            $personList[] = $this->buildPersonWithRelations($person);
        }
        return $personList;
    }

    private function buildPersonWithRelations(array $person): Person
    {
        $programmingLanguages = [];
        $personProgrammingLanguageRelation = $this->repository->findBy(static::PERSON_PROGRAMMING_LANGUAGE_RELATION_TABLE_NAME, 'person_id', $person['id']);
        foreach ($personProgrammingLanguageRelation as $relation) {
            $languagesList = $this->repository->findBy(static::PROGRAMMING_LANGUAGE_TABLE_NAME, 'id', $relation['programming_language_id']);
            $programmingLanguages[] = ProgrammingLanguage::fromArray(array_shift($languagesList));
        }
        return new Person($person['id'], $person['name'], $programmingLanguages);
    }

    public function searchPersonByProgrammingLanguage(array $programmingLanguagesList): array
    {
        $matchedPersonList = [];
        $allPeople = $this->getAllPeople();
        /** @var Person $person */
        foreach ($allPeople as $person) {
            $personProgrammingLanguagesList = array_map(function ($programmingLanguage) {
                    /** @var ProgrammingLanguage $programmingLanguage */
                    return $programmingLanguage->getName();
                },
                $person->getProgrammingLanguages()
            );

            if (count(array_diff($programmingLanguagesList, $personProgrammingLanguagesList)) === 0) {
                $matchedPersonList[] = $person;
            }
        }
        return $matchedPersonList;
    }

    public function getProgrammingLanguageByName(string $name): ?ProgrammingLanguage
    {
        $languagesList = $this->repository->findBy(static::PROGRAMMING_LANGUAGE_TABLE_NAME, 'name', $name, false);
        if (empty($languagesList)) {
            return null;
        } else {
            return ProgrammingLanguage::fromArray(array_shift($languagesList));
        }
    }

    public function persist($object)
    {
        $persistStrategy = new RelationsStrategy($object);
        foreach ($persistStrategy->add() as $data) {
            $this->repository->add($data['tableName'], $data['data']);
        }
        $this->repository->flush();
        return $object;
    }

    public function remove($object): void
    {
        $persistStrategy = new RelationsStrategy($object);
        foreach ($persistStrategy->remove() as $data) {
            $this->repository->delete($data['tableName'], $data['data']['parameter'], $data['data']['value']);
        }
        $this->repository->flush();
    }
}
