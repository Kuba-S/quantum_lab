<?php
declare(strict_types=1);

namespace QL\Domain\Person\Command;

use QL\Domain\Person\Infrastructure\PersonRepository;

class RemoveProgrammingLanguageCommandHandler
{
    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function removeProgrammingLanguageAction(RemoveProgrammingLanguageCommand $removeProgrammingLanguageCommand)
    {
        $person = $this->personRepository->getProgrammingLanguageByName($removeProgrammingLanguageCommand->getName());
        $this->personRepository->remove($person);
    }
}
