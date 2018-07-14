<?php
declare(strict_types=1);

namespace QL\Domain\Person\ReadModel;

use QL\Domain\Person\DomainModel\PersonFormatter;
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

    public function getAllPeopleAction()
    {
        return $this->personRepository->getAllPeople();
    }

    public function findByNameAction(FindPersonByNameQuery $findPersonByStringQuery)
    {
        return $this->personRepository->searchPersonByName($findPersonByStringQuery->getSearchString());
    }
}
