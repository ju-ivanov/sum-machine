<?php

declare(strict_types=1);

namespace App\Services\Response;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ResponseFactory
{
    private const JSON_OPTIONS = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;

    public static function success(array $data = null, int $status = Response::HTTP_OK, array $headers = []): JsonResponse
    {
        return new JsonResponse(self::format($data, $status), $status, $headers, self::JSON_OPTIONS);
    }

    public static function failure(string $errorMessage, int $status = Response::HTTP_INTERNAL_SERVER_ERROR, array $headers = []): JsonResponse
    {
        return new JsonResponse(self::format(null, $status, $errorMessage), $status, $headers, self::JSON_OPTIONS);
    }

    public static function format(?array $data, int $status, ?string $errorMessage = null): array
    {
        $content = [
            'data' => $data,
            'error' => null,
        ];

        if (is_string($errorMessage)) {
            $content['error'] = [
                'code' => $status,
                'message' => $errorMessage,
            ];
        }

        return $content;
    }
}
