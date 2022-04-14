<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Response;

use App\Services\Response\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;
use Tests\Unit\UnitTestCase;

class ResponseFactoryTest extends UnitTestCase
{
    public function testDefaultSuccess(): void
    {
        $response = ResponseFactory::success();
        $decodedResponseContent = json_decode((string) $response->getContent(), true);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertNull($decodedResponseContent['data']);
        self::assertNull($decodedResponseContent['error']);
    }

    public function testSuccess(): void
    {
        $status = Response::HTTP_CREATED;
        $data = [
            'foo1' => 'bar1',
            'foo2' => 'bar2',
        ];
        $headers = [
            'header1' => 'value1',
            'header2' => 'value2',
        ];

        $response = ResponseFactory::success($data, $status, $headers);
        $decodedResponseContent = json_decode((string) $response->getContent(), true);

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertEquals('value1', $response->headers->get('header1'));
        self::assertEquals('value2', $response->headers->get('header2'));
        self::assertEquals('bar1', $decodedResponseContent['data']['foo1']);
        self::assertEquals('bar2', $decodedResponseContent['data']['foo2']);
        self::assertNull($decodedResponseContent['error']);
    }

    public function testDefaultFailure(): void
    {
        $errorMessage = 'Lorem ipsum';

        $response = ResponseFactory::failure($errorMessage);
        $decodedResponseContent = json_decode((string) $response->getContent(), true);

        self::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
        self::assertNull($decodedResponseContent['data']);
        self::assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $decodedResponseContent['error']['code']);
        self::assertEquals($errorMessage, $decodedResponseContent['error']['message']);
    }

    public function testFailure(): void
    {
        $errorMessage = 'Lorem ipsum';
        $status = Response::HTTP_BAD_REQUEST;
        $headers = [
            'header1' => 'value1',
            'header2' => 'value2',
        ];

        $response = ResponseFactory::failure($errorMessage, $status, $headers);
        $decodedResponseContent = json_decode((string) $response->getContent(), true);

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertEquals('value1', $response->headers->get('header1'));
        self::assertEquals('value2', $response->headers->get('header2'));
        self::assertNull($decodedResponseContent['data']);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $decodedResponseContent['error']['code']);
        self::assertEquals($errorMessage, $decodedResponseContent['error']['message']);
    }
}
