<?php

declare(strict_types=1);

namespace Tests\Api\SumMachine;

use App\Repositories\NumberRepositoryInterface;
use DateTime;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Tests\Api\ApiTestCase;

class RemoveLastNumberServiceTest extends ApiTestCase
{
    private string $method = 'DELETE';
    private string $url = '/number';

    public function testWithoutToken(): void
    {
        $this->json($this->method, $this->url, []);

        $this->response->assertStatus(Response::HTTP_FORBIDDEN);
        $this->response->assertJsonStructure($this->structure()->error());
    }

    public function testWithInvalidToken(): void
    {
        $this->json($this->method, $this->url, [], [self::TOKEN_HEADER => Uuid::uuid4()]);

        $this->response->assertStatus(Response::HTTP_NOT_FOUND);
        $this->response->assertJsonStructure($this->structure()->error());
    }

    public function testWithEmptyNumberStack(): void
    {
        $this->json($this->method, $this->url, [], [self::TOKEN_HEADER => $this->generateToken()]);

        $this->response->assertStatus(Response::HTTP_BAD_REQUEST);
        $this->response->assertJsonStructure($this->structure()->error());
    }

    public function testRemoveLastNumber(): void
    {
        $this->truncateAll();

        $token = $this->create()->token();
        $number1 = $this->create()->number($token);
        // @phpstan-ignore-next-line
        $number1->setCreatedAt(DateTime::createFromFormat('Y-m-d', '2022-01-01'));
        $number2 = $this->create()->number($token);
        // @phpstan-ignore-next-line
        $number2->setCreatedAt(DateTime::createFromFormat('Y-m-d', '2022-01-10'));
        $number3 = $this->create()->number($token);
        // @phpstan-ignore-next-line
        $number3->setCreatedAt(DateTime::createFromFormat('Y-m-d', '2022-01-05'));
        $numberRepository = $this->app->make(NumberRepositoryInterface::class);
        $numberRepository->save($number1, $number2, $number3);

        $this->json($this->method, $this->url, [], [self::TOKEN_HEADER => $token->getId()->toString()]);

        $numbers = $numberRepository->findAll();
        self::assertCount(2, $numbers);

        $lastNumber = $numberRepository->find($number2);
        self::assertNull($lastNumber);

        $this->response->assertStatus(Response::HTTP_OK);
        $this->response->assertJsonStructure(['data' => $this->structure()->numbersCount()]);
        $this->response->assertJsonPath('data.count', 2);
    }
}
