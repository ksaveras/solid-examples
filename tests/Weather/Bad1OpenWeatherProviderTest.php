<?php

namespace App\Test\Weather\Bad1;

use App\Weather\Bad1\OpenWeatherProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class Bad1OpenWeatherProviderTest.
 */
class Bad1OpenWeatherProviderTest extends TestCase
{
    public function testWithEmptyArgument(): void
    {
        $this->expectException('BadMethodCallException');

        (new OpenWeatherProvider('', 'DEMO'))
            ->getWeatherInfo('');
    }

    public function testWithInvalidArgument(): void
    {
        $this->expectException('TypeError');

        (new OpenWeatherProvider('', 'DEMO'))
            ->getWeatherInfo(null);
    }

    public function testGetWeatherInfo(): void
    {
        $url = __DIR__.'/data/%LOCATION%_%APIKEY%.json';
        $service = new OpenWeatherProvider($url, 'DEMO');

        $weatherInfo = $service->getWeatherInfo('dummy');

        $this->assertEquals('dummy', $weatherInfo->getLocation());
        $this->assertEquals(20, $weatherInfo->getTemp());
        $this->assertEquals(77, $weatherInfo->getHumidity());
        $this->assertEquals(1100, $weatherInfo->getPressure());
    }
}
