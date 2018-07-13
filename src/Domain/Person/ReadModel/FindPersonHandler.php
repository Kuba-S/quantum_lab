<?php
declare(strict_types=1);

namespace QL\Domain\Person\ReadModel;

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

    public function findByStringAction(FindPersonByStringQuery $findPersonByStringQuery): string
    {
        return $findPersonByStringQuery->getSearchString();
    }
}
