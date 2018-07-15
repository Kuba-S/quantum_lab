<?php
declare(strict_types=1);

namespace QL\Domain\Person\Command;

use QL\Command\Validator;

class AddPersonCommandValidator implements Validator
{
    /**
     * @var AddPersonCommand
     */
    private $addPersonCommand;

    public function __construct(AddPersonCommand $addPersonCommand)
    {
        $this->addPersonCommand = $addPersonCommand;
    }

    public function validate(): void
    {
        if (empty($this->addPersonCommand->getFirstName()) || !ctype_alpha($this->addPersonCommand->getFirstName())) {
            $errorMessagesList[] = 'First name cannot be empty and must contain only alphabetic characters';
        }

        if (empty($this->addPersonCommand->getLastName()) || !ctype_alpha($this->addPersonCommand->getLastName())) {
            $errorMessagesList[] = 'Last name cannot be empty and must contain only alphabetic characters';
        }

        if (empty($this->addPersonCommand->getProgrammingLanguageList())
            || count($this->addPersonCommand->getProgrammingLanguageList()) !== count(array_unique($this->addPersonCommand->getProgrammingLanguageList()))
        ) {
            $errorMessagesList[] = 'Duplicates found in programming languages.';
        }

        if (!empty($errorMessagesList)) {
            throw new \InvalidArgumentException(implode(PHP_EOL, $errorMessagesList));
        }
    }
}
