<?php
declare(strict_types=1);

namespace QL\Infrastructure;

class JsonRepository implements Repository
{
    /**
     * @var string
     */
    private $jsonFilePath;

    /**
     * @var array
     */
    private $dbData;

    public function __construct(string $jsonFilePath)
    {
        $this->jsonFilePath = $jsonFilePath;
        $this->loadData();
    }

    public function add(string $tableKey, array $data): void
    {
        $this->validateTableKey($tableKey);

        if (isset($data['id'])) {
            if ($data['id'] !== null && isset($jsonData[$tableKey][$data['id']])) {
                throw new \LogicException('Id: "' . $data['id'] . '" already exists.');
            }
            $this->dbData[$tableKey][$data['id']] = $data;
        } else {
            $this->dbData[$tableKey][] = $data;
        }
    }

    public function delete(string $tableKey, string $parameter, string $value): void
    {
        $dataToDelete = $this->findBy($tableKey, $parameter, $value);
        foreach ($dataToDelete as $key => $toDelete) {
            unset($this->dbData[$tableKey][$key]);
        }
    }

    public function getAll(string $tableKey): array
    {
        $this->validateTableKey($tableKey);

        return $this->dbData[$tableKey];
    }

    public function findBy(string $tableKey, string $parameter, string $searchedString, bool $wildcard = false): array
    {
        $this->validateTableKey($tableKey);

        $foundRecords = array_filter(array_column($this->dbData[$tableKey], $parameter), function ($value) use ($searchedString, $wildcard) {
            if ($wildcard) {
                return false !== strpos(strtolower($value), strtolower($searchedString));
            } else {
                return strtolower($value) === strtolower($searchedString);
            }
        });

        return array_intersect_key($this->dbData[$tableKey], array_flip(array_intersect_key(array_keys($this->dbData[$tableKey]), $foundRecords)));
    }

    private function loadData(): void
    {
        $jsonData = file_get_contents($this->jsonFilePath);
        $this->dbData = json_decode($jsonData, true);
    }

    private function validateTableKey($tableKey): void
    {
        if (!isset($this->dbData[$tableKey])) {
            throw new \LogicException('Table "' . $tableKey . '" in database doesn\'t exists.');
        }
    }

    public function flush(): void
    {
        if (false === file_put_contents($this->jsonFilePath, json_encode($this->dbData))) {
            throw new \LogicException('Unable to store data in database.');
        }
    }
}
