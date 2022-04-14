<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TokenNotFoundException extends NotFoundHttpException
{
    public const MESSAGE = 'Token not found';
}
