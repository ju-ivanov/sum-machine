<?php

declare(strict_types=1);

namespace Tests\Api\SumMachine;

use App\Repositories\NumberRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Tests\Api\ApiTestCase;

class AddNumberServiceTest extends ApiTestCase
{
    private string $method = 'POST';
    private string $url = '/number';

    public function testWithoutToken(): void
    {
        $requestData = [
            'number' => $this->getFaker()->numberBetween(-100, 100),
        ];

        $this->json($this->method, $this->url, $requestData);

        $this->response->assertStatus(Response::HTTP_FORBIDDEN);
        $this->response->assertJsonStructure($this->structure()->error());
    }

    public function testWithInvalidToken(): void
    {
        $requestData = [
            'number' => $this->getFaker()->numberBetween(-100, 100),
        ];

        $this->json($this->method, $this->url, $requestData, [self::TOKEN_HEADER => Uuid::uuid4()]);

        $this->response->assertStatus(Response::HTTP_NOT_FOUND);
        $this->response->assertJsonStructure($this->structure()->error());
    }

    public function testAddNumber(): void
    {
        $this->truncateAll();

        $requestData = [
            'number' => $this->getFaker()->numberBetween(-100, 100),
        ];

        $this->json($this->method, $this->url, $requestData, [self::TOKEN_HEADER => $this->generateToken()]);

        $numberRepository = $this->app->make(NumberRepositoryInterface::class);
        $numbers = $numberRepository->findAll();

        self::assertCount(1, $numbers);
        self::assertEquals($requestData['number'], $numbers[0]->getNumber());

        $this->response->assertStatus(Response::HTTP_OK);
        $this->response->assertJsonStructure(['data' => $this->structure()->numbersCount()]);
        $this->response->assertJsonPath('data.count', 1);
    }
}
