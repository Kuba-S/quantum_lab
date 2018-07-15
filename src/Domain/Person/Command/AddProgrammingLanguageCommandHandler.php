<?php
declare(strict_types=1);

namespace QL\Domain\Person\Command;

use QL\Domain\Person\DomainModel\ProgrammingLanguage;
use QL\Domain\Person\Infrastructure\PersonRepository;

class AddProgrammingLanguageCommandHandler
{
    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function addProgrammingLanguageAction(AddProgrammingLanguageCommand $addProgrammingLanguageCommand)
    {
        $validator = new AddProgrammingLanguageCommandValidator();
        $validator->validate($addProgrammingLanguageCommand);
        $programmingLanguage = $this->personRepository->getProgrammingLanguageByName($addProgrammingLanguageCommand->getName());
        if (!empty($programmingLanguage)) {
            throw new \DomainException('Programming language already exists');
        }
        $this->personRepository->persist(ProgrammingLanguage::create($addProgrammingLanguageCommand->getName()));
    }
}
