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

    public function removeProgrammingLanguageAction(RemoveProgrammingLanguageCommand $removeProgrammingLanguageCommand): void
    {
        $programmingLanguage = $this->personRepository->getProgrammingLanguageByName($removeProgrammingLanguageCommand->getName());
        if (empty($programmingLanguage)) {
            throw new \InvalidArgumentException('Programming language: "' . $removeProgrammingLanguageCommand->getName() . '" doesn\'t exists.');
        }

        $this->personRepository->remove($programmingLanguage);
    }
}
