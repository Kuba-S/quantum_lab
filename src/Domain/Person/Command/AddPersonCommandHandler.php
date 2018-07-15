<?php
declare(strict_types=1);

namespace QL\Domain\Person\Command;

use QL\Domain\Person\DomainModel\Person;
use QL\Domain\Person\DomainModel\ProgrammingLanguage;
use QL\Domain\Person\Infrastructure\PersonRepository;

class AddPersonCommandHandler
{
    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function addPersonAction(AddPersonCommand $addPersonCommand): string
    {
        $programmingLanguagesList = [];
        foreach ($addPersonCommand->getProgrammingLanguageList() as $name) {
            $programmingLanguage = $this->personRepository->getProgrammingLanguageByName($name);
            if ($programmingLanguage === null) {
                $programmingLanguage = $this->personRepository->persist(ProgrammingLanguage::create($name));
            }
            $programmingLanguagesList[] = $programmingLanguage;
        }

        $person = Person::create($addPersonCommand->getFirstName() . ' ' . $addPersonCommand->getLastName(), $programmingLanguagesList);

        $this->personRepository->persist($person);
        return 'OK';
    }
}
