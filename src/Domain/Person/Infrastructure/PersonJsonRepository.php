<?php
declare(strict_types=1);

namespace QL\Domain\Person\Infrastructure;

use QL\Domain\Person\ReadModel\PersonRepository;
use QL\Infrastructure\JsonParamsStrategy;
use QL\Infrastructure\JsonRepository;

class PersonJsonRepository implements PersonRepository
{
    /**
     * @var JsonRepository
     */
    private $jsonRepository;

    public function __construct(JsonRepository $jsonRepository)
    {
        $this->jsonRepository = $jsonRepository;
    }

    public function getAllPeople(): array
    {
        $people = $this->jsonRepository->getAll(JsonParamsStrategy::PERSON_KEY);
        $peapleProgrammingLanguageRelation = $this->jsonRepository->getAll(JsonParamsStrategy::PERSON_PROGRAMMING_LANGUAGE_RELATION_KEY);
        $programmingLanguages = $this->jsonRepository->getAll(JsonParamsStrategy::PROGRAMMING_LANGUAGE_KEY);
        // TODO: Implement merge.
    }

    public function search(): array
    {
        // TODO: Implement search() method.
    }
}
