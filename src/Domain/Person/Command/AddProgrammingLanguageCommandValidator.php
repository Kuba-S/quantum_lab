<?php
declare(strict_types=1);

namespace QL\Domain\Person\Command;

use QL\Command\Validator;
use QL\Exception\ValidationException;

class AddProgrammingLanguageCommandValidator implements Validator
{
    /**
     * @var AddProgrammingLanguageCommand
     */
    private $addProgrammingLanguageCommand;

    public function __construct(AddProgrammingLanguageCommand $addProgrammingLanguageCommand)
    {
        $this->addProgrammingLanguageCommand = $addProgrammingLanguageCommand;
    }

    public function validate(): void
    {
        if (empty($this->addProgrammingLanguageCommand->getName())) {
            $errorMessagesList[] = 'Programming language name cannot be empty';
        }

        if (!empty($errorMessagesList)) {
            throw new ValidationException(implode(PHP_EOL, $errorMessagesList));
        }
    }
}
