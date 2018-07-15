<?php
declare(strict_types=1);

namespace QL\Domain\Person\ReadModel;

use QL\Domain\Person\Infrastructure\PersonRepository;

class FindPersonHandler
{
    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function getAllPeopleAction(): array
    {
        return $this->personRepository->getAllPeople();
    }

    public function findPersonByNameAction(FindPersonByNameQuery $findPersonByStringQuery): array
    {
        return $this->personRepository->searchPersonByName($findPersonByStringQuery->getSearchString());
    }

    public function findPersonByProgrammingLanguagesAction(FindPersonByProgrammingLanguagesQuery $byProgrammingLanguagesQuery): array
    {
        return $this->personRepository->searchPersonByProgrammingLanguage($byProgrammingLanguagesQuery->getProgrammingLanguages());
    }
}
