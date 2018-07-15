<?php
declare(strict_types=1);

namespace QL\Domain\Person\Command;

use QL\Domain\Person\Infrastructure\PersonRepository;
use QL\Exception\ValidationException;

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

    public function removePersonAction(RemovePersonCommand $removePersonCommand): string
    {
        $person = $this->personRepository->getPersonById($removePersonCommand->getId());
        if (empty($person)) {
            throw new ValidationException('Person with Id: "' . $removePersonCommand->getId() . '" doesn\'t exists.');
        }

        $this->personRepository->remove($person);
        return 'OK';
    }
}
