<?php
declare(strict_types=1);

namespace QL\Infrastructure;

interface Repository
{
    public function add(string $tableKey, array $data): void;

    public function delete(string $tableKey, string $parameter, string $value): void;

    public function getAll(string $tableKey): array;

    public function findBy(string $tableKey, string $parameter, string $searchedValue, bool $wildcard = false): array;

    public function flush(): void;
}
