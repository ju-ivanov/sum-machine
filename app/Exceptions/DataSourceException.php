<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

class DataSourceException extends RuntimeException
{
    public const MESSAGE = 'Could not access data source';
}
