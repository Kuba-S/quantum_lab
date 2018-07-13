<?php
declare(strict_types=1);

namespace QL\Infrastructure;

class JsonRepository
{
    /**
     * @var JsonRepository
     */
    private static $instance;

    /**
     * @var string
     */
    private $jsonFilePath;

    /**
     * @var array
     */
    private $dbData;

    private function __construct(string $jsonFilePath)
    {
        $this->jsonFilePath = $jsonFilePath;
        $this->loadData();
    }

    public static function getInstance(string $jsonFilePath): JsonRepository
    {
        if (self::$instance === null) {
            self::$instance = new self($jsonFilePath);
        }
        return self::$instance;
    }

    public function add(string $tableKey, int $id, array $parameters): void
    {
        $this->validateTableKey($tableKey);
        if (isset($jsonData[$tableKey][$id])) {
            throw new \InvalidArgumentException('Id: "' . $id . '" already exists.');
        }
        $this->dbData[$tableKey][$id] = $parameters;
    }

    public function update(string $tableKey, int $id, array $parameters): void
    {
        $this->validateTableKey($tableKey);
        if (!isset($this->dbData[$tableKey][$id])) {
            throw new \InvalidArgumentException('Id: "' . $id . '" doesn\'t exists.');
        }
        $this->dbData[$tableKey][$id] = $parameters;
    }

    public function delete(string $tableKey, int $id): void
    {
        $this->validateTableKey($tableKey);
        if (!isset($this->dbData[$id])) {
            throw new \InvalidArgumentException('Id: "' . $id . '" doesn\'t exists.');
        }
        unset($this->dbData[$tableKey][$id]);
    }

    public function getAll(string $tableKey): array
    {
        $this->validateTableKey($tableKey);

        return $this->dbData[$tableKey];
    }

    public function findBy(string $tableKey, string $parameter, string $searchedString): array
    {
        $this->validateTableKey($tableKey);
        if (!isset($this->dbData[$parameter])) {
            throw new \InvalidArgumentException('Parameter: "' . $parameter . '" doesn\'t exists.');
        }

        $foundRecords = array_filter(array_column($this->dbData[$tableKey], $parameter, 'id'), function ($value) use ($searchedString) {
            return false !== strpos(strtolower($value), strtolower($searchedString));
        });

        return array_intersect_key($this->dbData[$tableKey], $foundRecords);
    }

    private function loadData(): void
    {
        $jsonData = file_get_contents($this->jsonFilePath);
        $this->dbData = json_decode($jsonData, true);
    }

    private function validateTableKey($tableKey): void
    {
        if (!isset($this->dbData[$tableKey])) {
            throw new \InvalidArgumentException('Table "' . $tableKey . '" in database doesn\'t exists.');
        }
    }

    public function flush(): void
    {
        if (false === file_put_contents($this->jsonFilePath, json_encode($this->dbData))) {
            throw new \LogicException('Unable to store data in database.');
        }
    }
}
