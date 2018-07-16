<?php
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = [
                'ql\\application\\application' => '/Application/Application.php',
                'ql\\application\\clirequest' => '/Application/CliRequest.php',
                'ql\\application\\mappable' => '/Application/Mappable.php',
                'ql\\application\\validator' => '/Application/Validator.php',
                'ql\\domain\\person\\command\\addpersoncommand' => '/Domain/Person/Command/AddPersonCommand.php',
                'ql\\domain\\person\\command\\addpersoncommandhandler' => '/Domain/Person/Command/AddPersonCommandHandler.php',
                'ql\\domain\\person\\command\\addpersoncommandvalidator' => '/Domain/Person/Command/AddPersonCommandValidator.php',
                'ql\\domain\\person\\command\\addprogramminglanguagecommand' => '/Domain/Person/Command/AddProgrammingLanguageCommand.php',
                'ql\\domain\\person\\command\\addprogramminglanguagecommandhandler' => '/Domain/Person/Command/AddProgrammingLanguageCommandHandler.php',
                'ql\\domain\\person\\command\\addprogramminglanguagecommandvalidator' => '/Domain/Person/Command/AddProgrammingLanguageCommandValidator.php',
                'ql\\domain\\person\\command\\removepersoncommand' => '/Domain/Person/Command/RemovePersonCommand.php',
                'ql\\domain\\person\\command\\removepersoncommandhandler' => '/Domain/Person/Command/RemovePersonCommandHandler.php',
                'ql\\domain\\person\\command\\removeprogramminglanguagecommand' => '/Domain/Person/Command/RemoveProgrammingLanguageCommand.php',
                'ql\\domain\\person\\command\\removeprogramminglanguagecommandhandler' => '/Domain/Person/Command/RemoveProgrammingLanguageCommandHandler.php',
                'ql\\domain\\person\\domainmodel\\person' => '/Domain/Person/DomainModel/Person.php',
                'ql\\domain\\person\\domainmodel\\programminglanguage' => '/Domain/Person/DomainModel/ProgrammingLanguage.php',
                'ql\\domain\\person\\infrastructure\\personrepository' => '/Domain/Person/Infrastructure/PersonRepository.php',
                'ql\\domain\\person\\infrastructure\\relationsstrategy' => '/Domain/Person/Infrastructure/RelationsStrategy.php',
                'ql\\domain\\person\\readmodel\\findpersonbynamequery' => '/Domain/Person/ReadModel/FindPersonByNameQuery.php',
                'ql\\domain\\person\\readmodel\\findpersonbyprogramminglanguagesquery' => '/Domain/Person/ReadModel/FindPersonByProgrammingLanguagesQuery.php',
                'ql\\domain\\person\\readmodel\\findpersonhandler' => '/Domain/Person/ReadModel/FindPersonHandler.php',
                'ql\\exception\\validationexception' => '/Exception/ValidationException.php',
                'ql\\formatter\\formatter' => '/Formatter/Formatter.php',
                'ql\\formatter\\personcliformatter' => '/Formatter/PersonCliFormatter.php',
                'ql\\formatter\\programminglanguagecliformatter' => '/Formatter/ProgrammingLanguageCliFormatter.php',
                'ql\\infrastructure\\jsonrepository' => '/Infrastructure/JsonRepository.php',
                'ql\\infrastructure\\repository' => '/Infrastructure/Repository.php'
            ];
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    },
    true,
    false
);
