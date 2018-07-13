<?php
declare(strict_types=1);

namespace QL\Domain\Person\Command;

use QL\Domain\Person\DomainModel\ProgrammingLanguage;

interface CommandPersonRepository
{
    public function persist(object $object);

    public function update(object $object);

    public function remove(object $object);

    public function getProgrammingLanguageByName(string $name): ?ProgrammingLanguage;
}
