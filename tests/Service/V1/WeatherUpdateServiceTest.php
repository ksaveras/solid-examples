<?php

namespace App\Test\Service\V1;

use App\Entity\WeatherInfo;
use App\Manager\WeatherManager;
use App\Service\V1\WeatherUpdateService;
use App\Weather\WeatherProviderInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class WeatherUpdateServiceTest.
 */
class WeatherUpdateServiceTest extends TestCase
{
    public function testDownloadWeatherInfo(): void
    {
        $location = 'demo';
        $entity = (new WeatherInfo())
            ->setLocation($location)
            ->setTemp(11.7)
            ->setPressure(1100)
            ->setHumidity(77);

        $weatherProvider = $this->createMock(WeatherProviderInterface::class);
        $weatherProvider->expects($this->once())
            ->method('getWeatherInfo')
            ->with($location)
            ->willReturn($entity);

        $weatherManager = $this->createMock(WeatherManager::class);
        $weatherManager->expects($this->once())
            ->method('updateWeather')
            ->with($entity);

        $service = new WeatherUpdateService(
            $weatherProvider,
            $weatherManager
        );

        $weatherInfo = $service->downloadWeatherInfo($location);
        $this->assertSame($entity, $weatherInfo);
    }
}
