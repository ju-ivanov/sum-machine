<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\Response\ResponseFactory;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class TokenHeader
{
    public const TOKEN_HEADER = 'Token';

    /**
     * @return JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $tokenHeader = $request->header(self::TOKEN_HEADER);

        try {
            $token = Uuid::fromString(is_string($tokenHeader) ? $tokenHeader : '');
        } catch (InvalidArgumentException) {
            return ResponseFactory::failure('Token header is invalid', Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
