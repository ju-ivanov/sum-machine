<?php

declare(strict_types=1);

namespace App\Entities;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class AbstractEntity
{
    protected function generateId(): UuidInterface
    {
        return Uuid::uuid4();
    }
}
