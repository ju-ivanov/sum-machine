<?php

declare(strict_types=1);

namespace Tests\Api;

use Doctrine\DBAL\Connection;

class TruncateService
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function tokens(): void
    {
        $this->truncateTables('tokens');
    }

    public function numbers(): void
    {
        $this->truncateTables('numbers');
    }

    private function truncateTables(string ...$name): void
    {
        $tableNames = implode(', ', $name);

        $this->connection->executeStatement('TRUNCATE ' . $tableNames . ' CASCADE');
    }
}
