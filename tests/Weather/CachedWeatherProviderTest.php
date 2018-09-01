<?php

namespace App\Test\Weather;

use App\Entity\WeatherInfo;
use App\Weather\CachedWeatherProvider;
use App\Weather\WeatherProviderInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

/**
 * Class CachedWeatherProviderTest.
 */
class CachedWeatherProviderTest extends TestCase
{

    public function testGetWeatherInfo(): void
    {
        $location = 'wonderland';
        $cache = new ArrayAdapter(120, false);

        $weatherInfo = (new WeatherInfo())
            ->setLocation($location)
            ->setTemp(17)
            ->setHumidity(77)
            ->setPressure(1105);

        $mock = $this->createMock(WeatherProviderInterface::class);
        $mock->expects($this->once())
            ->method('getWeatherInfo')
            ->willReturn($weatherInfo);

        $service = new CachedWeatherProvider($cache, $mock);

        $result = $service->getWeatherInfo($location);

        $this->assertTrue($cache->hasItem($location));
        $this->assertEquals($weatherInfo, $result);
        $this->assertEquals($weatherInfo, $cache->getItem($location)->get());

        $cachedWeather = $service->getWeatherInfo($location);

        $this->assertEquals($cachedWeather, $weatherInfo);
    }
}
