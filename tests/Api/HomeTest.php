<?php

declare(strict_types=1);

namespace Tests\Api;

class HomeTest extends ApiTestCase
{
    public function testHome(): void
    {
        $this->get('/');

        $this->seeJsonEquals([
            'data' => [
                'name' => config('app.name'),
            ],
            'error' => null,
        ]);
    }
}
