<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Response\Serializers;

use App\Services\Response\Serializers\SumResponseSerializer;
use Tests\Unit\UnitTestCase;

class SumResponseSerializerTest extends UnitTestCase
{
    /**
     * @dataProvider inputDataProvider
     */
    public function testSerialize(int $input): void
    {
        $serializer = $this->app->make(SumResponseSerializer::class);
        $result = $serializer->serialize($input);

        self::assertEquals($input, $result['sum']);
    }

    public function inputDataProvider(): array
    {
        return [[-1000000], [-10], [0], [10], [1000000]];
    }
}
