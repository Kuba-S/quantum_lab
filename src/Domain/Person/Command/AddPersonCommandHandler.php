<?php
declare(strict_types=1);

namespace QL\Domain\Person\Command;

use QL\Domain\Person\DomainModel\Person;
use QL\Domain\Person\DomainModel\ProgrammingLanguage;

class AddPersonCommandHandler
{
    /**
     * @var CommandPersonRepository
     */
    private $personRepository;

    public function __construct(CommandPersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function addPersonAction(AddPersonCommand $addPersonCommand)
    {
        $validator = new AddPersonCommandValidator();
        $validator->validate($addPersonCommand);

        $programmingLanguagesList = [];
        foreach ($addPersonCommand->getProgrammingLanguageList() as $name) {
            $programmingLanguage = $this->personRepository->getProgrammingLanguageByName($name);
            if ($programmingLanguagesList === null) {
                $programmingLanguage = $this->personRepository->persist(ProgrammingLanguage::create($name));
            }
            $programmingLanguagesList[] = $programmingLanguage;
        }

        $person = Person::create($addPersonCommand->getFirstName() . ' ' . $addPersonCommand->getLastName(), $programmingLanguagesList);

        $this->personRepository->persist($person);
    }
}
