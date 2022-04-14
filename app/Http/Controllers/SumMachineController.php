<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\DataSourceException;
use App\Exceptions\EmptyNumberStackException;
use App\Exceptions\TokenNotFoundException;
use App\Http\Middleware\TokenHeader;
use App\Services\Response\ResponseFactory;
use App\Services\Response\Serializers\NumbersCountResponseSerializer;
use App\Services\Response\Serializers\SumResponseSerializer;
use App\Services\Response\Serializers\TokenResponseSerializer;
use App\Services\SumMachine\AddNumberService;
use App\Services\SumMachine\GetSumService;
use App\Services\SumMachine\RemoveLastNumberService;
use App\Services\SumMachine\ResetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Laravel\Lumen\Routing\Controller as BaseController;
use LogicException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\Response;

class SumMachineController extends BaseController
{
    public function reset(
        Request $request,
        ResetService $resetService,
        TokenResponseSerializer $tokenResponseSerializer
    ): JsonResponse {
        $token = $resetService->handle();

        return ResponseFactory::success($tokenResponseSerializer->serialize($token), Response::HTTP_CREATED);
    }

    /**
     * @throws DataSourceException
     * @throws TokenNotFoundException
     */
    public function addNumber(
        Request $request,
        AddNumberService $addNumberService,
        NumbersCountResponseSerializer $numbersCountResponseSerializer
    ): JsonResponse {
        $validated = $this->validate($request, [
            'number' => ['required', 'integer', 'min:-1000000', 'max:1000000'],
        ]);

        $numbersCount = $addNumberService->handle(
            $this->extractTokenId($request),
            $validated['number']
        );

        return ResponseFactory::success($numbersCountResponseSerializer->serialize($numbersCount));
    }

    /**
     * @throws DataSourceException
     * @throws TokenNotFoundException
     */
    public function removeLastNumber(
        Request $request,
        RemoveLastNumberService $removeLastNumberService,
        NumbersCountResponseSerializer $numbersCountResponseSerializer
    ): JsonResponse {
        try {
            $numbersCount = $removeLastNumberService->handle($this->extractTokenId($request));
        } catch (EmptyNumberStackException $e) {
            return ResponseFactory::failure($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return ResponseFactory::success($numbersCountResponseSerializer->serialize($numbersCount));
    }

    /**
     * @throws DataSourceException
     * @throws TokenNotFoundException
     */
    public function getSum(
        Request $request,
        GetSumService $getSumService,
        SumResponseSerializer $sumResponseSerializer
    ): JsonResponse {
        $sum = $getSumService->handle($this->extractTokenId($request));

        return ResponseFactory::success($sumResponseSerializer->serialize($sum));
    }

    private function extractTokenId(Request $request): UuidInterface
    {
        $tokenHeader = $request->header(TokenHeader::TOKEN_HEADER);

        try {
            $token = Uuid::fromString(is_string($tokenHeader) ? $tokenHeader : '');
        } catch (InvalidArgumentException $e) {
            throw new LogicException('TokenHeader middleware was not applied correctly for current route');
        }

        return $token;
    }
}
