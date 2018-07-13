<?php
declare(strict_types=1);

namespace QL\Domain\Person\Command;

class AddPersonCommandValidator
{
    public function validate(AddPersonCommand $addPersonCommand)
    {
        if (empty($addPersonCommand->getFirstName()) || !ctype_alpha($addPersonCommand->getFirstName())) {
            $errorMessagesList[] = 'First name cannot be empty and must contain only alphabetic characters';
        }

        if (empty($addPersonCommand->getLastName()) || !ctype_alpha($addPersonCommand->getLastName())) {
            $errorMessagesList[] = 'Last name cannot be empty and must contain only alphabetic characters';
        }

        if (empty($addPersonCommand->getProgrammingLanguageList())
            || count($addPersonCommand->getProgrammingLanguageList()) !== count(array_unique($addPersonCommand->getProgrammingLanguageList()))
        ) {
            $errorMessagesList[] = 'Duplicates found in programming languages.';
        }

        if (!empty($errorMessagesList)) {
            throw new \InvalidArgumentException(implode(PHP_EOL, $errorMessagesList));
        }
    }
}
