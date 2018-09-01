<?php

namespace App\Test\Service\Bad1;

use App\Entity\WeatherInfo;
use App\Manager\WeatherManager;
use App\Service\Bad1\WeatherUpdateService;
use App\Weather\WeatherProviderInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

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
            ->willReturn($entity);

        $weatherManager = $this->createMock(WeatherManager::class);
        $weatherManager->expects($this->once())
            ->method('updateWeather')
            ->with($entity);

        $cache = new ArrayAdapter(120, false);

        $service = new WeatherUpdateService(
            $weatherProvider,
            $weatherManager,
            $cache
        );

        $weatherInfo = $service->downloadWeatherInfo($location);
        $this->assertSame($entity, $weatherInfo);
    }
}
