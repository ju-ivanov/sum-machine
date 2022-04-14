<?php

declare(strict_types=1);

namespace Tests\Api\SumMachine;

use App\Repositories\NumberRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Tests\Api\ApiTestCase;

class GetSumServiceTest extends ApiTestCase
{
    private string $method = 'GET';
    private string $url = '/sum';

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

    public function testGetSum(): void
    {
        $this->truncateAll();

        $token = $this->create()->token();
        $number1 = $this->create()->number($token);
        $number2 = $this->create()->number($token);
        $number3 = $this->create()->number($token);
        $numberRepository = $this->app->make(NumberRepositoryInterface::class);
        $numberRepository->save($number1, $number2, $number3);

        $this->json($this->method, $this->url, [], [self::TOKEN_HEADER => $token->getId()->toString()]);

        $sum = $number1->getNumber() + $number2->getNumber() + $number3->getNumber();

        $this->response->assertStatus(Response::HTTP_OK);
        $this->response->assertJsonStructure(['data' => $this->structure()->sum()]);
        $this->response->assertJsonPath('data.sum', $sum);
    }
}
