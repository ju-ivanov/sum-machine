<?php

declare(strict_types=1);

namespace Tests\Api\SumMachine;

use App\Repositories\TokenRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Tests\Api\ApiTestCase;

class ResetServiceTest extends ApiTestCase
{
    private string $method = 'POST';
    private string $url = '/reset';

    public function testReset(): void
    {
        $this->truncateAll();

        $this->json($this->method, $this->url);

        $tokenRepository = $this->app->make(TokenRepositoryInterface::class);
        $tokens = $tokenRepository->findAll();

        self::assertCount(1, $tokens);
        $token = $tokens[0];

        $this->response->assertStatus(Response::HTTP_CREATED);
        $this->response->assertJsonStructure(['data' => $this->structure()->token()]);
        $this->response->assertJsonPath('data.token', $token->getId()->toString());
    }
}
