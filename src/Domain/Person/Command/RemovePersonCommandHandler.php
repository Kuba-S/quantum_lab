<?php
declare(strict_types=1);

namespace QL\Domain\Person\Command;

use QL\Domain\Person\Infrastructure\PersonRepository;

class RemovePersonCommandHandler
{
    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function removePersonAction(RemovePersonCommand $removePersonCommand)
    {
        $person = $this->personRepository->getPersonById($removePersonCommand->getId());
        if (empty($person)) {
            throw new \InvalidArgumentException('Person with Id: "' . $removePersonCommand->getId() . '" doesn\'t exists.');
        }

        $this->personRepository->remove($person);
    }
}
