<?php
declare(strict_types=1);

namespace QL\Domain\Person\Command;

use QL\Domain\Person\Infrastructure\PersonRepository;
use QL\Exception\ValidationException;

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

    public function removeProgrammingLanguageAction(RemoveProgrammingLanguageCommand $removeProgrammingLanguageCommand): string
    {
        $programmingLanguage = $this->personRepository->getProgrammingLanguageByName($removeProgrammingLanguageCommand->getName());
        if (empty($programmingLanguage)) {
            throw new ValidationException('Programming language: "' . $removeProgrammingLanguageCommand->getName() . '" doesn\'t exists.');
        }

        $peopleWithProgrammingLanguage = $this->personRepository->searchPersonByProgrammingLanguage([$programmingLanguage->getName()]);
        if (!empty($peopleWithProgrammingLanguage)) {
            throw new ValidationException('Programming language: "' . $removeProgrammingLanguageCommand->getName() . '" in use.');
        }

        $this->personRepository->remove($programmingLanguage);
        return 'OK';
    }
}
