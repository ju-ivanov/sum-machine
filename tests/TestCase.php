<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     */
    public function createApplication(): Application
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }

    protected function mockGuzzleClient(array $responses): void
    {
        $this->app->singleton(GuzzleClient::class, function () use ($responses) {
            $mock = new MockHandler($responses);

            $handlerStack = HandlerStack::create($mock);

            return new GuzzleClient(['handler' => $handlerStack]);
        });
    }
}
