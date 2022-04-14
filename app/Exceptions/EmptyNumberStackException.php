<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

class EmptyNumberStackException extends RuntimeException
{
    public const MESSAGE = 'Number stack is empty';
}
