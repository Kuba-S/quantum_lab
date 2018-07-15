<?php
declare(strict_types=1);

namespace QL\Domain\Person\Command;

use QL\Domain\Person\DomainModel\ProgrammingLanguage;
use QL\Domain\Person\Infrastructure\PersonRepository;
use QL\Exception\ValidationException;

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

    public function addProgrammingLanguageAction(AddProgrammingLanguageCommand $addProgrammingLanguageCommand): void
    {
        $programmingLanguage = $this->personRepository->getProgrammingLanguageByName($addProgrammingLanguageCommand->getName());
        if (!empty($programmingLanguage)) {
            throw new ValidationException('Programming language already exists');
        }
        $this->personRepository->persist(ProgrammingLanguage::create($addProgrammingLanguageCommand->getName()));
    }
}
