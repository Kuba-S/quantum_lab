<?php

namespace QL\Domain\Person\ReadModel;

interface PersonRepository
{
    public function getAllPeople(): array;

    public function search(): array;
}
