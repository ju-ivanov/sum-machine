<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Services\Response\ResponseFactory;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateHttpResponse;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * @param Request $request
     *
     * @throws Throwable
     *
     * @return IlluminateHttpResponse|JsonResponse
     */
    public function render($request, Throwable $e)
    {
        $errorMessage = 'Internal Server Error';
        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($e instanceof ValidationException) {
            $errorMessage = implode('', $e->errors());
            $statusCode = Response::HTTP_BAD_REQUEST;
        }

        if ($e instanceof HttpExceptionInterface) {
            $errorMessage = $e->getMessage();
            $statusCode = $e->getStatusCode();
        }

        if ($e instanceof NotFoundHttpException) {
            $errorMessage = $e->getMessage();
            $statusCode = Response::HTTP_NOT_FOUND;
        }

        return ResponseFactory::failure($errorMessage, $statusCode);
    }
}
