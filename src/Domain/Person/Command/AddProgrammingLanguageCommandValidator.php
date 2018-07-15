<?php
declare(strict_types=1);

namespace QL\Domain\Person\Command;

class AddProgrammingLanguageCommandValidator
{
    public function validate(AddProgrammingLanguageCommand $addProgrammingLanguageCommand)
    {
        if (empty($addProgrammingLanguageCommand->getName())) {
            $errorMessagesList[] = 'Programming language name cannot be empty';
        }

        if (!empty($errorMessagesList)) {
            throw new \InvalidArgumentException(implode(PHP_EOL, $errorMessagesList));
        }
    }
}
